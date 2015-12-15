<?php
namespace WebDeploy\Filesystem;

use WebDeploy\Exception;

class File
{
    private $file;

    public function create($file)
    {
        $this->file = $file;

        return $this;
    }

    public function open($file)
    {
        if (!is_file($file)) {
            throw new Exception\NotFoundException(__('File %s not exists', $file));
        }

        $this->file = $file;

        return $this;
    }

    public function temporal()
    {
        $this->file = tempnam(sys_get_temp_dir(), uniqid());

        return $this;
    }

    public function write($contents, $flag = null)
    {
        file_put_contents($this->file, $contents, $flag);

        return $this;
    }

    public function read()
    {
        return file_get_contents($this->file);
    }

    public function getFileName()
    {
        return $this->file;
    }
}