<?php
namespace WebDeploy\Processor;

use Exception as BaseException;
use WebDeploy\Exception;
use WebDeploy\Repository;
use WebDeploy\Router\Route;
use WebDeploy\Shell\Shell;

class Mysql extends Processor
{
    public function index()
    {
        if (!$this->check() || !($processor = input('processor'))) {
            return null;
        }

        switch ($processor) {
            case 'mysql-test-local':
                $status = $this->mysqlTest(config('mysql')['local']);
                break;

            case 'mysql-test-remote':
                $status = $this->mysqlTest(config('mysql')['remote']);
                break;

            default:
                return array();
        }

        return array($processor => $status);
    }

    protected function mysqlTest($config)
    {
        try {
            (new Repository\Mysql($config))->connect();
        } catch (BaseException $e) {
            return array('error' => $e->getMessage());
        }

        return array('success' => __('Connection successfully'));
    }

    public function compare()
    {
        $config = config('mysql');

        try {
            $local = (new Repository\Mysql($config['local']))->dump();
            $remote = (new Repository\Mysql($config['remote']))->dump();

            return Repository\Mysql::diff($remote, $local, true);
        } catch (BaseException $e) {
            return array('error' => $e->getMessage());
        }
    }

    public function update()
    {
        if (!$this->check() || !($processor = input('processor'))) {
            return null;
        }

        switch ($processor) {
            case 'mysql-update':
                $status = $this->mysqlUpdate();
                break;

            default:
                return array();
        }

        return array($processor => $status);
    }

    public function mysqlUpdate()
    {
        if (!($sql = input('sql'))) {
            throw new Exception\UnexpectedValueException(__('SQL string is empty'));
        }

        try {
            (new Repository\Mysql(config('mysql')['remote']))->connect()->update($sql);
        } catch (BaseException $e) {
            return array('error' => $e->getMessage());
        }

        return array('success' => __('Changes was applied successfully'));
    }
}
