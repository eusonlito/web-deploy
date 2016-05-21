<?php
namespace WebDeploy\Controller;

use WebDeploy\Processor;
use WebDeploy\Repository;

class Git extends Controller
{
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
            'commit' => $this->git()->setCommitLinks(array_shift($logs)),
            'status' => $this->git()->setDiffLinks(array_shift($logs)),
            'path' => array_shift($logs)
        ));
    }

    public function commit()
    {
        if (!($hash = input('h'))) {
            redirect(route('/git'));
        }

        meta()->meta('title', 'GIT Commit');

        if (is_object($error = $this->check())) {
            return $error;
        }

        return self::content('git.commit', array(
            'hash' => $hash,
            'log' => $this->git()->show($hash)->getShellAndLog()
        ));
    }

    public function diff()
    {
        if (!($file = input('f'))) {
            redirect(route('/git'));
        }

        meta()->meta('title', 'GIT Diff');

        if (is_object($error = $this->check())) {
            return $error;
        }

        return self::content('git.diff', array(
            'file' => $file,
            'log' => $this->git()->diff($file)->getShellAndLog()
        ));
    }

    public function update()
    {
        meta()->meta('title', 'GIT Update');

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

        $git = $this->git();
        $last = (int)input('last') ?: config('git')['log_history'];

        return self::content('git.log', array(
            'last' => $last,
            'log' => $git->setCommitLinks($git->getLogStat($last))
        ));
    }
}
