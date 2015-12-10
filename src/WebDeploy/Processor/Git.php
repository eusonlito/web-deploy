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

    private function exec($cmd)
    {
        return (new Shell)->log(true)->exec($cmd)->getLogs()[0];
    }

    private function gitPull()
    {
        return $this->exec('git pull');
    }

    private function gitReset()
    {
        return $this->exec('git reset --hard');
    }

    private function gitCheckout()
    {
        if (!($hash = input('commit-hash'))) {
            return null;
        }

        return $this->exec('git checkout '.$hash);
    }

    private function gitBranch()
    {
        if (!($name = input('branch-name'))) {
            return null;
        }

        return $this->exec('git checkout '.$name);
    }
}
