<?php
namespace WebDeploy\Controller;

use Exception;

class Phpinfo extends Controller
{
    public function index()
    {
        meta()->set('title', 'PHP Info');

        return self::page('body', 'phpinfo.index');
    }
}
