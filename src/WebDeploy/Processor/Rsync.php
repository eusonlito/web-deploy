<?php
namespace WebDeploy\Processor;

use Exception;
use WebDeploy\Repository;
use WebDeploy\Router\Route;

class Rsync extends Processor
{
    public function index()
    {
        if (!$this->check() || !($processor = input('processor'))) {
            return null;
        }

        switch ($processor) {
            case 'rsync-test':
                $status = $this->rsyncTest();
                break;

            default:
                return array();
        }

        return array($processor => $status);
    }

    public function update()
    {
        if (!$this->check() || !($processor = input('processor'))) {
            return null;
        }

        switch ($processor) {
            case 'rsync-upload':
                $status = $this->rsyncUpload();
                break;

            default:
                return array();
        }

        return array($processor => $status);
    }

    protected function rsyncTest()
    {
        try {
            (new Repository\Rsync)->connect();
        } catch (Exception $e) {
            return array('error' => $e->getMessage());
        }

        return array('success' => __('Connection successfully'));
    }

    protected function rsyncUpload()
    {
        try {
            $log = (new Repository\Rsync)->upload(input('files'))->getLog();
        } catch (Exception $e) {
            return array('error' => $e->getMessage());
        }

        return array('success' => $log);
    }
}
