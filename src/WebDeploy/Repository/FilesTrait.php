<?php
namespace WebDeploy\Repository;

use WebDeploy\Exception;
use WebDeploy\Filesystem;

trait FilesTrait
{
    public function getRecentFiles($days, $gitIgnoreParser = null)
    {
        $base = $this->config['path'];

        list($exclude, $include) = $this->getExcludeIncludeFromGitignore($base, $gitIgnoreParser);

        $files = (new Filesystem\Directory($base))
            ->recursive(true)
            ->filterExclude($this->config['exclude'])
            ->filterExclude($exclude)
            ->filterInclude($include)
            ->filterOnlyFile(true)
            ->filterNewer(strtotime('-'.$days.' days'))
            ->get();

        return array_map(function ($file) use ($base) {
            $name = str_replace($base, '', $file);

            return array(
                'code' => base64_encode($name),
                'name' => $name,
                'date' => filemtime($file)
            );
        }, $files);
    }

    private function getValidFiles($files)
    {
        if (empty($files) || !is_array($files)) {
            return array();
        }

        $valid = array();

        foreach ($files as $file) {
            if (is_file($this->config['path'].($file = base64_decode($file)))) {
                $valid[] = $file;
            }
        }

        return $valid;
    }
}
