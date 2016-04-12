<?php
namespace WebDeploy\Repository;

use Exception as BaseException;
use PDO;
use WebDeploy\Exception;
use WebDeploy\Filesystem;
use WebDeploy\Router\Route;
use WebDeploy\Shell\Shell;

class Mysql extends Repository
{
    private $connection;
    private $log = array();

    public static function check()
    {
        $config = config('mysql');

        foreach (['local', 'remote'] as $host) {
            if (empty($config[$host]['host']) || empty($config[$host]['user'])) {
                throw new Exception\UnexpectedValueException(__('You need configure the config/mysql.php file'));
            }

            (new self($config[$host]))->connect();
        }

        return true;
    }

    public function __construct($config)
    {
        foreach (['host', 'user', 'database'] as $required) {
            if (empty($config[$required])) {
                throw new Exception\UnexpectedValueException(__('<strong>%s</strong> parameter is required', $required));
            }
        }

        $this->config = $config;

        return $this;
    }

    private function getDSN()
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

    public function dump()
    {
        $file = Filesystem\File::temporal();

        $log = (new Shell)->exec(
            'export MYSQL_PWD="'.$this->config['password'].'";'

            .' mysqldump'
            .' --host="'.$this->config['host'].'"'
            .' --user="'.$this->config['user'].'"'
            .' --port="'.$this->config['port'].'"'
            .' --no-data'
            .' --result-file="'.$file.'"'
            .' "'.$this->config['database'].'"'
        )->getLog();

        if ($log['success'] || $log['error']) {
            throw new Exception\UnexpectedValueException($log['success'] ?: $log['error']);
        }

        return $file;
    }

    public function update($sql)
    {
        $file = Filesystem\File::unique(static::getDumpFolder().'/mysql-update.sql');

        Filesystem\File::write($file, $sql);

        if ($this->connection->exec($sql) === false) {
            throw new Exception\UnexpectedValueException($this->connection->errorInfo()[2]);
        }

        return true;
    }

    public static function diff($sql1, $sql2, $delete = false)
    {
        $log = (new Shell(Route::getBinPath()))
            ->exec('./mysqldiff "'.$sql1.'" "'.$sql2.'"')
            ->getLog();

        if ($delete) {
            if (is_file($sql1)) {
                unlink($sql1);
            }

            if (is_file($sql2)) {
                unlink($sql2);
            }
        }

        if ($log['error']) {
            throw new Exception\UnexpectedValueException($log['error']);
        }

        return trim(preg_replace("/(^|\n)#.*/", '', $log['success']));
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

    public static function getDumpFolder()
    {
        return Route::getStoragePath('/dump');
    }
}
