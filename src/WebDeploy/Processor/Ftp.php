<?php
namespace WebDeploy\Processor;

use Exception;
use WebDeploy\Repository;
use WebDeploy\Router\Route;

class Ftp extends Processor
{
    public function index()
    {
        if (!$this->check() || !($processor = input('processor'))) {
            return null;
        }

        switch ($processor) {
            case 'ftp-test':
                $status = $this->ftpTest();
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
            case 'ftp-upload':
                $status = $this->ftpUpload();
                break;

            default:
                return array();
        }

        return array($processor => $status);
    }

    protected function ftpTest()
    {
        try {
            (new Repository\Ftp)->connect()->close();
        } catch (Exception $e) {
            return array('error' => $e->getMessage());
        }

        return array('success' => __('Connection successfully'));
    }

    protected function ftpUpload()
    {
        try {
            $log = (new Repository\Ftp)->upload(input('files'))->getLog();
        } catch (Exception $e) {
            return array('error' => $e->getMessage());
        }

        return array('success' => $log);
    }
}
