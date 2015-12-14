<?php
namespace WebDeploy\Controller;

use Exception;
use WebDeploy\Shell\Shell;

class Index extends Controller
{
    private function check()
    {
        try {
            Shell::check();
        } catch (Exception $e) {
            return self::error('index', $e->getMessage());
        }
    }

    public function index()
    {
        if (is_object($error = $this->check())) {
            return $error;
        }

        $responses = (new Shell)
            ->exec('whoami')
            ->exec('pwd')
            ->getLogs();

        return self::content('index.index', array(
            'whoami' => array_shift($responses),
            'path' => array_shift($responses)
        ));
    }
}
