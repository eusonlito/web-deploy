<?php
namespace WebDeploy\Processor;

use Exception;
use WebDeploy\Repository;
use WebDeploy\Router\Route;

class Mysql extends Processor
{
    public function index()
    {
        if (!$this->check() || !($processor = input('processor'))) {
            return null;
        }

        switch ($processor) {
            case 'mysql-test':
                $status = $this->mysqlTest();
                break;

            default:
                return array();
        }

        return array($processor => $status);
    }

    protected function mysqlTest()
    {
        try {
            (new Repository\Mysql)->connect();
        } catch (Exception $e) {
            return array('error' => $e->getMessage());
        }

        return array('success' => __('Connection successfully'));
    }
}
