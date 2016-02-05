<?php
namespace WebDeploy\Repository;

use Exception as BaseException;
use PDO;

use WebDeploy\Exception;
use WebDeploy\Filesystem;

class Mysql extends Repository
{
    private $connection;
    private $log = array();

    public static function check()
    {
        $config = config('mysql');

        if (empty($config['host']) || empty($config['user'])) {
            throw new Exception\UnexpectedValueException(__('You need configure the config/mysql.php file'));
        }

        (new self)->connect();

        return true;
    }

    public function __construct()
    {
        $this->loadConfig('mysql');

        foreach (['host', 'user', 'database'] as $required) {
            if (empty($this->config[$required])) {
                throw new Exception\UnexpectedValueException(__('<strong>%s</strong> parameter is required', $required));
            }
        }
    }

    private function getDSN ()
    {
        $dsn = 'mysql:host='.$this->config['host'];

        if (isset($this->config['port'])) {
            $dsn .= ';port='.$this->config['port'];
        } elseif ($this->config['unix_socket']) {
            $dsn .= ';unix_socket='.$this->config['unix_socket'];
        }

        $dsn .= ';dbname='.$this->config['database'];

        if (isset($this->config['charset'])) {
            $dsn .= ';charset='.$this->config['charset'];
        }

        return $dsn;
    }

    public function connect()
    {
        try {
            $this->connection = new PDO($this->getDSN(), $this->config['user'], $this->config['password']);
        } catch (BaseException $e) {
            throw new Exception\UnexpectedValueException(__('Could not connect to <strong>%s</strong>:', $e->getMessage()));
        }

        return $this;
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
