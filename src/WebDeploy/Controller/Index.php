<?php
namespace WebDeploy\Controller;

class Index extends Controller
{
    public function index()
    {
        return self::page('body', 'index.index');
    }
}