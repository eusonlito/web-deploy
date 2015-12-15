<?php
namespace WebDeploy\Repository;

use WebDeploy\Filesystem;

trait FilesTrait
{
    public function getRecentFiles($days)
    {
        $base = $this->config['path'];

        list($exclude, $include) = $this->getExcludeIncludeFromGitignore($base);

        $files = (new Filesystem\Directory($base))
            ->recursive(true)
            ->filterExclude($this->config['exclude'])
            ->filterExclude($exclude)
            ->filterInclude($include)
            ->filterOnlyFile(true)
            ->filterNewer(strtotime('-'.$days.' days'))
            ->get();

        foreach ($files as &$file) {
            $name = str_replace($base.'/', '', $file);

            $file = array(
                'code' => base64_encode($name),
                'name' => $name,
                'date' => filemtime($file)
            );
        }

        return $files;
    }

    private function getValidFiles($files)
    {
        if (empty($files) || !is_array($files)) {
            return array();
        }

        $valid = array();

        foreach ($files as $file) {
            if (is_file($this->config['path'].'/'.($file = base64_decode($file)))) {
                $valid[] = $file;
            }
        }

        return $valid;
    }
}
