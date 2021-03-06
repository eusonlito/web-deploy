<?php
namespace WebDeploy\Processor;

use WebDeploy\Repository;
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

            case 'git-fetch':
                $status = $this->gitFetch();
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

            case 'composer-install':
                $status = $this->composerInstall();
                break;

            default:
                return array();
        }

        return array($processor => $status);
    }

    protected function exec($function, $parameter = null)
    {
        return (new Repository\Git(null, true))->$function($parameter)->getShellAndLog();
    }

    protected function gitPull()
    {
        return $this->exec('pull');
    }

    protected function gitFetch()
    {
        return $this->exec('fetch');
    }

    protected function gitReset()
    {
        return $this->exec('reset');
    }

    protected function gitCheckout()
    {
        if (!($hash = input('commit-hash'))) {
            return null;
        }

        return $this->exec('checkout', $hash);
    }

    protected function gitBranch()
    {
        if (!($name = input('branch-name'))) {
            return null;
        }

        return $this->exec('checkout', $name);
    }

    protected function composerInstall()
    {
        return (new Repository\Composer(null, true))->install()->getShellAndLog();
    }
}
