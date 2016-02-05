<?php
namespace WebDeploy\Controller;

use Exception;
use WebDeploy\Processor;
use WebDeploy\Repository;

class Mysql extends Controller
{
    public function index()
    {
        meta()->meta('title', 'MySQL Status');

        if (is_object($response = $this->check(true, false))) {
            return $response;
        }

        return self::content('mysql.index', array(
            'config' => config('mysql'),
            'processor' => (new Processor\Mysql)->index()
        ));
    }
}
