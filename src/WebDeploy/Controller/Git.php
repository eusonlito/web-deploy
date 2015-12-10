<?php
namespace WebDeploy\Controller;

use WebDeploy\Processor;
use WebDeploy\Shell\Shell;

class Git extends Controller
{
    private function check()
    {
        if ((new Shell)->exec('which git')->getLogs()[0]['success']) {
            return true;
        }

        self::page('body', 'git.layout');

        return self::template('content', 'molecules.error', array(
            'message' => __('GIT is not installed')
        ));
    }

    public function index()
    {
        if (is_object($error = $this->check())) {
            return $error;
        }

        meta()->meta('title', 'GIT Status');

        $log = (new Shell)
            ->exec('git rev-parse --abbrev-ref HEAD')
            ->exec('git log --name-status HEAD^..HEAD')
            ->exec('git status')
            ->getLogs();

        return self::content('git.index', array(
            'path' => config('git')['path'],
            'branch' => array_shift($log),
            'commit' => array_shift($log),
            'status' => array_shift($log)
        ));
    }

    public function update()
    {
        if (is_object($error = $this->check())) {
            return $error;
        }

        meta()->meta('title', 'GIT Update');

        $log = array_map(function ($line) {
            $line = explode(' ', $line, 2);

            return array(
                'hash' => $line[0],
                'message' => preg_replace('/\s\+[0-9]{4}\s/', ' ', $line[1])
            );
        }, explode("\n", (new Shell)
            ->exec('git log --date=iso --pretty=format:"%h %cd [%an] %s"')
            ->getLogs()[0]['success'])
        );

        return self::content('git.update', array(
            'log' => $log,
            'processor' => (new Processor\Git)->update()
        ));
    }

    public function log()
    {
        if (is_object($error = $this->check())) {
            return $error;
        }

        meta()->meta('title', 'GIT Log');

        $last = (int)input('last') ?: 50;

        return self::content('git.log', array(
            'last' => $last,
            'log' => (new Shell)->exec('git log --stat -n '.$last)->getLogs()[0]
        ));
    }
}
