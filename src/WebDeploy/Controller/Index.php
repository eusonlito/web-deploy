<?php
namespace WebDeploy\Controller;

use Exception;
use WebDeploy\Shell\Shell;

class Index extends Controller
{
    public function index()
    {
        try {
            Shell::check();
        } catch (Exception $e) {
            return self::error('index', $e->getMessage());
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
