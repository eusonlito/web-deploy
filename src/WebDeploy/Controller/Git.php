<?php
namespace WebDeploy\Controller;

use WebDeploy\Processor;
use WebDeploy\Shell\Shell;

class Git extends Controller
{
    public function index()
    {
        meta()->meta('title', 'GIT Status');

        $log = (new Shell)
            ->exec('git rev-parse --abbrev-ref HEAD')
            ->exec('git log --name-status HEAD^..HEAD')
            ->exec('git status')
            ->getLogs();

        return self::content('git.index', array(
            'branch' => $log[0],
            'commit' => $log[1],
            'status' => $log[2]
        ));
    }

    public function update()
    {
        meta()->meta('title', 'GIT Update');

        $log = explode("\n", (new Shell)->exec('git log --oneline')->getLogs()[0]['success']);

        $log = array_map(function($line) {
            $line = explode(' ', $line, 2);

            return array(
                'hash' => $line[0],
                'message' => $line[1]
            );
        }, $log);

        return self::content('git.update', array(
            'log' => $log,
            'processor' => (new Processor\Git)->update()
        ));
    }

    public function log()
    {
        meta()->meta('title', 'GIT Log');

        $last = (int)input('last') ?: 50;

        return self::content('git.log', array(
            'last' => $last,
            'log' => (new Shell)->exec('git log --stat -n '.$last)->getLogs()[0]
        ));
    }
}
