<?php
namespace PHPDeploy\Controller;

class Index extends Controller
{
    public function index()
    {
        return template()->set('body', 'pages.index');
    }
}