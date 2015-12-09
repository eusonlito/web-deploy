<?php
namespace WebDeploy\Controller;

class Index extends Controller
{
    public function index()
    {
        return template()->set('body', 'pages.index');
    }
}