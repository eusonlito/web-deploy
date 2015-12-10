<?php
namespace WebDeploy\Controller;

use WebDeploy\Processor;
use WebDeploy\Repository;
use WebDeploy\Shell\Shell;

class Git extends Controller
{
    private function check()
    {
        if ((new Shell)->exec('which git')->getLog()['success']) {
            return true;
        }

        self::page('body', 'git.layout');

        return self::template('content', 'molecules.error', array(
            'message' => __('GIT is not installed')
        ));
    }

    public function git()
    {
        return new Repository\Git;
    }

    public function index()
    {
        meta()->meta('title', 'GIT Status');

        if (is_object($error = $this->check())) {
            return $error;
        }

        $logs = $this->git()
            ->currentBranch()
            ->lastCommit()
            ->status()
            ->getShell()
            ->exec('pwd')
            ->getLogs();

        return self::content('git.index', array(
            'branch' => array_shift($logs),
            'commit' => array_shift($logs),
            'status' => array_shift($logs),
            'path' => array_shift($logs)
        ));
    }

    public function update()
    {
        meta()->meta('title', 'Web Deploy Update');

        if (is_object($error = $this->check())) {
            return $error;
        }

        $processor = (new Processor\Git)->update();

        $git = $this->git();

        return self::content('git.update', array(
            'log' => $git->getLogSimpleList(),
            'branches' => $git->getBranchesList(),
            'processor' => $processor
        ));
    }

    public function log()
    {
        meta()->meta('title', 'GIT Log');

        if (is_object($error = $this->check())) {
            return $error;
        }

        $last = (int)input('last') ?: config('git')['log_history'];

        return self::content('git.log', array(
            'last' => $last,
            'log' => $this->git()->getLogStat($last)
        ));
    }
}
