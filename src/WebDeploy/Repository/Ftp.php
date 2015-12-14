<?php
namespace WebDeploy\Repository;

use WebDeploy\Exception;
use WebDeploy\Filesystem;

class Ftp extends Repository
{
    private $connection;
    private $config = array();
    private $log = array();

    public static function check()
    {
        if (!function_exists('ftp_connect')) {
            throw new Exception\BadFunctionCallException(__('PHP functions related with <strong>ftp</strong> are not installed'));
        }

        if (empty(config('ftp')['host'])) {
            throw new Exception\UnexpectedValueException(__('You need configure the config/ftp.php file'));
        }

        (new self)->connect()->close();

        return true;
    }

    public function __construct()
    {
        $this->config = array_merge(config('project'), config('ftp'));
    }

    public function connect()
    {
        $this->connection = ftp_connect($this->config['host'], $this->config['port'], $this->config['timeout']);

        if (!$this->connection) {
            throw new Exception\UnexpectedValueException(__('Could not connect to <strong>%s</strong> using port <strong>%s</strong>', $this->config['host'], $this->config['port']));
        }

        if (!@ftp_login($this->connection, $this->config['user'], $this->config['password'])) {
            throw new Exception\UnexpectedValueException(__('Bad authentication data to connect to <strong>%s</strong> with user <strong>%s</strong>', $this->config['host'], $this->config['user']));
        }

        ftp_pasv($this->connection, true);

        return $this;
    }

    public function close()
    {
        if ($this->connection) {
            ftp_close($this->connection);
        }

        return $this;
    }

    public function getRecentFiles($days)
    {
        $base = $this->config['path'];

        list($exclude, $include) = $this->getExcludeIncludeFromGitignore($base);

        $files = (new Filesystem\Directory($base))
            ->recursive(true)
            ->filterExclude($this->config['exclude'])
            ->filterExclude($exclude)
            ->filterInclude($include)
            ->filterOnlyFile(true)
            ->filterNewer(strtotime('-'.$days.' days'))
            ->get();

        foreach ($files as &$file) {
            $name = str_replace($base.'/', '', $file);

            $file = array(
                'code' => base64_encode($name),
                'name' => $name,
                'date' => filemtime($file)
            );
        }

        return $files;
    }

    private function getExcludeIncludeFromGitignore($directory)
    {
        $filesystem = new Filesystem\Directory($directory);
        $excludes = $includes = array();

        foreach ($filesystem->scanRecursiveFiltered('/\.gitignore$') as $file) {
            list($to_exclude, $to_include) = $this->getExcludeIncludeFromGitignoreParser($file);

            $excludes = array_merge($excludes, $to_exclude);
            $includes = array_merge($includes, $to_include);
        }

        return array($excludes, $includes);
    }

    private function getExcludeIncludeFromGitignoreParser($file)
    {
        $directory = preg_replace('#/$#', '', dirname($file));
        $excludes = $includes = array();

        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $file) {
            $file = trim($file);

            if (strpos($file, '#') === 0) {
                continue;
            }

            $dir = is_dir($directory.'/'.$file);

            if (strstr($file, '.')) {
                $file = str_replace('.', '\\.', $file);
            }

            if (strstr($file, '*')) {
                $file = str_replace('*', '.*', $file);
            }

            if ($dir) {
                if (!strstr($file, '.*')) {
                    $file .= '.*';
                }
            } else {
                $file .= '$';

                if (!strstr($file, '.*')) {
                    $file = '.*'.$file;
                }
            }

            $file = $directory.'/'.preg_replace('#^/#', '', $file);

            if (strstr($file, '!')) {
                $includes[] = str_replace('!', '', $file);
            } else {
                $excludes[] = $file;
            }
        }

        return array($excludes, $includes);
    }

    public function upload($files)
    {
        $files = $this->getValidFiles($files);

        if (empty($files)) {
            throw new Exception\UnexpectedValueException(__('File list is empty'));
        }

        $this->connect();

        $local = $this->config['path'].'/';
        $remote = $this->config['remote_path'];

        foreach ($files as $file) {
            $this->put($local.$file, $remote.$file);
        }

        return $this;
    }

    private function getValidFiles($files)
    {
        if (empty($files) || !is_array($files)) {
            return array();
        }

        $valid = array();

        foreach ($files as $file) {
            if (is_file($this->config['path'].'/'.($file = base64_decode($file)))) {
                $valid[] = $file;
            }
        }

        return $valid;
    }

    private function put($local, $remote)
    {
        if ($this->chdir(dirname($remote)) === false) {
            return false;
        }

        $status = @ftp_put($this->connection, $remote, $local, FTP_BINARY);

        return $this->log('PUT', $local.' '.$remote, $status);
    }

    private function chdir($directory)
    {
        if (@ftp_chdir($this->connection, $directory)) {
            return $this->log('CHDIR', $directory, true);
        }

        $directory = array_filter(explode('/', $directory));
        $path = '/'.array_shift($directory);

        if (!@ftp_chdir($this->connection, $path)) {
            return $this->log('CHDIR', $path, false);
        }

        $status = true;

        foreach ($directory as $path) {
            if (@ftp_chdir($this->connection, $path)){
                $this->log('CHDIR', $path, true);
                continue;
            }

            $status = @ftp_mkdir($this->connection, $path) ? true : false;
            $this->log('MKDIR', $path, $status);

            if ($status === false) {
                return false;
            }

            $status = @ftp_chdir($this->connection, $path) ? true : false;
            $this->log('CHDIR', $path, $status);
        }

        return $status;
    }

    private function log($cmd, $arguments, $status)
    {
        $this->log[] = array(
            'cmd' => $cmd,
            'arguments' => $arguments,
            'status' => $status
        );

        return $status;
    }

    public function getLog()
    {
        return $this->log;
    }
}
