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

    private function ssh()
    {
        return 'ssh'
            .' -o BatchMode=yes'
            .' -o StrictHostKeyChecking=no'
            .' -o UserKnownHostsFile=/dev/null'
            .' -o ConnectTimeout='.$this->config['timeout']
            .' -p '.$this->config['port'];
    }

    private function sshCommand($cmd)
    {
        return $this->ssh()
            .' '.$this->config['user'].'@'.$this->config['host']
            .' '.$cmd;
    }

    private function rsync($options = '')
    {
        $cmd = 'rsync -av --no-perms --no-owner --no-group --no-times'
            .' '.$options
            .' -e \''.$this->ssh().'\'';

        foreach ($this->config['exclude'] as $exclude) {
            $cmd .= ' --exclude '.$exclude;
        }

        return $cmd
            .' '.$this->config['path']
            .' '.$this->config['user'].'@'.$this->config['host']
            .':'.$this->config['remote_path'];
    }

    public function connect()
    {
        $log = (new Shell)->exec($this->sshCommand('echo OK 2>&1'))->getLog();

        if (empty($log['success'])) {
            throw new Exception\UnexpectedValueException($log['error']);
        }

        return $log;
    }

    public function getUpdatedFiles()
    {
        dd((new Shell)->exec($this->rsync('--dry-run'))->getLog());
    }
}
