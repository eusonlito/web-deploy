<?php
namespace WebDeploy\Repository;

use WebDeploy\Exception;
use WebDeploy\Filesystem;

class Ftp extends Repository
{
    use GitIgnoreTrait, FilesTrait {
        getRecentFiles as getRecentFilesTrait;
    }

    private $connection;
    private $log = array();

    public static function check()
    {
        if (!function_exists('ftp_connect')) {
            throw new Exception\BadFunctionCallException(__('PHP functions related with <strong>ftp</strong> are not installed'));
        }

        $config = config('ftp');

        if (empty($config['host']) || empty($config['user'])) {
            throw new Exception\UnexpectedValueException(__('You need configure the config/ftp.php file'));
        }

        (new self)->connect()->close();

        return true;
    }

    public function __construct()
    {
        $this->loadConfig('ftp');
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
        return self::getRecentFilesTrait($days, 'getExcludeIncludeFromGitignoreParserToPHP');
    }

    public function upload($files)
    {
        $files = $this->getValidFiles($files);

        if (empty($files)) {
            throw new Exception\UnexpectedValueException(__('File list is empty'));
        }

        $this->connect();

        foreach ($files as $file) {
            $this->put($this->config['path'].$file, $this->config['remote_path'].$file);
        }

        return $this;
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
            if (@ftp_chdir($this->connection, $path)) {
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
