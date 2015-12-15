<?php
namespace WebDeploy\Repository;

use WebDeploy\Exception;
use WebDeploy\Filesystem;
use WebDeploy\Shell\Shell;

class Rsync extends Repository
{
    use GitIgnoreTrait, FilesTrait;

    private $connection;
    private $config = array();
    private $log = array();

    public static function check()
    {
        Shell::check();

        if (!(new Shell)->exec('which rsync')->getLog()['success']) {
            throw new Exception\BadFunctionCallException(__('<strong>rsync</strong> command is not installed'));
        }

        $config = config('rsync');

        if (empty($config['host']) || empty($config['user'])) {
            throw new Exception\UnexpectedValueException(__('You need configure the config/rsync.php file'));
        }

        (new self)->connect();

        return true;
    }

    public function __construct()
    {
        $this->config = array_merge(config('project'), config('rsync'));
    }

    private function ssh($cmd)
    {
        return 'ssh'
            .' -o BatchMode=yes'
            .' -o StrictHostKeyChecking=no'
            .' -o UserKnownHostsFile=/dev/null'
            .' -o ConnectTimeout='.$this->config['timeout']
            .' '.$this->config['user'].'@'.$this->config['host']
            .' '.$cmd;
    }

    public function connect()
    {
        $log = (new Shell)->exec($this->ssh('echo OK 2>&1'))->getLog();

        if (empty($log['success'])) {
            throw new Exception\UnexpectedValueException($log['error']);
        }

        return $log;
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
