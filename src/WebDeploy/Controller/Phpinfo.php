<?php
namespace WebDeploy\Controller;

use Exception;

class Phpinfo extends Controller
{
    public function index()
    {
        return self::page('body', 'phpinfo.index');
    }
}
