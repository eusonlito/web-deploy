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
            case 'git-fetch':
                $status = $this->gitFetch();
                break;

            case 'git-pull':
                $status = $this->gitPull();
                break;

            case 'git-stash':
                $status = $this->gitStash();
                break;

            case 'git-checkout':
                $status = $this->gitCheckout();
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

    private function gitFetch()
    {
        return $this->exec('git fetch --all');
    }

    private function gitPull()
    {
        return $this->exec('git pull');
    }

    private function gitStash()
    {
        return $this->exec('git stash');
    }

    private function gitCheckout()
    {
        if (!($hash = input('commit-hash'))) {
            return null;
        }

        return $this->exec('git checkout '.$hash);
    }
}