<?php
namespace WebDeploy\Controller;

use WebDeploy\Filesystem;
use WebDeploy\Processor;
use WebDeploy\Repository;

class Mysql extends Controller
{
    public function index()
    {
        meta()->meta('title', 'MySQL Status');

        if (is_object($response = $this->check(true, true))) {
            return $response;
        }

        $config = config('mysql');

        return self::content('mysql.index', array(
            'local' => $config['local'],
            'remote' => $config['remote'],
            'processor' => (new Processor\Mysql)->index()
        ));
    }

    public function update()
    {
        meta()->meta('title', 'MySQL Update');

        if (is_object($response = $this->check(true, true))) {
            return $response;
        }

        $config = config('mysql');

        return self::content('mysql.update', array(
            'local' => $config['local'],
            'remote' => $config['remote'],
            'diff' => ((input('compare') === 'true') ? (new Processor\Mysql)->compare() : null),
            'processor' => (new Processor\Mysql)->update()
        ));
    }

    public function log()
    {
        meta()->meta('title', 'MySQL Log');

        $dumps = Repository\Mysql::getDumpFolder();

        $files = array_map(function($value) {
            return basename($value);
        }, (new Filesystem\Directory($dumps))->get());

        rsort($files);

        if (($file = input('file')) && in_array($file, $files, true)) {
            $response = array(
                'command' => date('Y-m-d H:i:s', (int)explode('-', $file, 2)[0]),
                'success' => Filesystem\File::read($dumps.'/'.$file)
            );
        } else {
            $response = array();
        }

        return self::content('mysql.log', array(
            'files' => $files,
            'file' => $file,
            'response' => $response
        ));
    }
}
