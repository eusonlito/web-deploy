<?php
namespace WebDeploy\Controller;

use WebDeploy\Processor;
use WebDeploy\Router\Route;
use WebDeploy\Shell\Shell;

class Admin extends Controller
{
    private function check()
    {
        if ($this->shell()->exec('which git')->getLogs()[0]['success']) {
            return true;
        }

        self::page('body', 'admin.layout');

        return self::template('content', 'molecules.error', array(
            'message' => __('GIT is not installed')
        ));
    }

    public function shell()
    {
        return new Shell(Route::getBasePath());
    }

    public function index()
    {
        if (is_object($error = $this->check())) {
            return $error;
        }

        meta()->meta('title', 'Web Deploy Status');

        $logs = $this->shell()
            ->exec('pwd')
            ->exec('git rev-parse --abbrev-ref HEAD')
            ->exec('git log --name-status HEAD^..HEAD')
            ->exec('git status')
            ->getLogs();

        return self::content('admin.index', array(
            'path' => array_shift($logs),
            'branch' => array_shift($logs),
            'commit' => array_shift($logs),
            'status' => array_shift($logs)
        ));
    }

    public function update()
    {
        if (is_object($error = $this->check())) {
            return $error;
        }

        $processor = (new Processor\Admin)->update();

        meta()->meta('title', 'Web Deploy Update');

        $logs = $this->shell()
            ->exec('git log --date=iso --pretty=format:"%h %cd [%an] %s"')
            ->exec('git branch')
            ->getLogs();

        $log = array_map(function ($line) {
            $line = explode(' ', $line, 2);

            return array(
                'hash' => $line[0],
                'message' => preg_replace('/\s\+[0-9]{4}\s/', ' ', $line[1])
            );
        }, explode("\n", array_shift($logs)['success']));

        $branches = array_map(function ($line) {
            return array(
                'current' => preg_match('/^\*/', $line),
                'name' => trim(preg_replace('/^\* /', '', $line))
            );
        }, explode("\n", array_shift($logs)['success']));

        return self::content('admin.update', array(
            'log' => $log,
            'branches' => $branches,
            'processor' => $processor
        ));
    }

    public function log()
    {
        if (is_object($error = $this->check())) {
            return $error;
        }

        meta()->meta('title', 'Web Deploy Log');

        $last = (int)input('last') ?: 50;

        return self::content('admin.log', array(
            'last' => $last,
            'log' => $this->shell()->exec('git log --stat -n '.$last)->getLogs()[0]
        ));
    }
}
