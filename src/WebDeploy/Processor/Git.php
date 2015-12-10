<?php
namespace WebDeploy\Processor;

use WebDeploy\Shell\Shell;

class Git extends Processor
{
    public function update()
    {
        if (!$this->check() || !($processor = input('processor'))) {
            return null;
        }

        switch ($processor) {
            case 'git-pull':
                $status = $this->gitPull();
                break;

            case 'git-reset':
                $status = $this->gitReset();
                break;

            case 'git-checkout':
                $status = $this->gitCheckout();
                break;

            case 'git-branch':
                $status = $this->gitBranch();
                break;

            default:
                return array();
        }

        return array($processor => $status);
    }

    protected function exec($cmd)
    {
        return (new Shell)->log(true)->exec($cmd)->getLogs()[0];
    }

    protected function gitPull()
    {
        return $this->exec('git pull');
    }

    protected function gitReset()
    {
        return $this->exec('git reset --hard');
    }

    protected function gitCheckout()
    {
        if (!($hash = input('commit-hash'))) {
            return null;
        }

        return $this->exec('git checkout '.$hash);
    }

    protected function gitBranch()
    {
        if (!($name = input('branch-name'))) {
            return null;
        }

        return $this->exec('git checkout '.$name);
    }
}
