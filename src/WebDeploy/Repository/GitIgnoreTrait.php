<?php
namespace WebDeploy\Repository;

use WebDeploy\Filesystem;

trait GitIgnoreTrait
{
    private function getExcludeIncludeFromGitignore($directory, $parser)
    {
        if (empty($parser)) {
            throw new Exception\UnexpectedValueException(__('parser is required'));
        }

        $filesystem = new Filesystem\Directory($directory);
        $excludes = $includes = array();

        foreach ($filesystem->scanRecursiveFiltered('/\.gitignore$') as $file) {
            list($to_exclude, $to_include) = $this->$parser($directory, $file);

            $excludes = array_merge($excludes, $to_exclude);
            $includes = array_merge($includes, $to_include);
        }

        return array($excludes, $includes);
    }

    private function getExcludeIncludeFromGitignoreParserToPHP($base, $file)
    {
        $directory = rtrim(dirname($file), '/');
        $excludes = $includes = array();

        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $file) {
            $file = trim($file);

            if (strpos($file, '#') === 0) {
                continue;
            }

            $dir = is_dir($directory.'/'.$file);

            if (strstr($file, '.')) {
                $file = str_replace('.', '\\.', $file);
            }

            if (strstr($file, '*')) {
                $file = str_replace('*', '.*', $file);
            }

            if ($dir) {
                if (!strstr($file, '.*')) {
                    $file .= '.*';
                }
            } else {
                $file .= '$';

                if (!strstr($file, '.*')) {
                    $file = '.*'.$file;
                }
            }

            $file = $directory.'/'.ltrim($file, '/');

            if (strstr($file, '!')) {
                $includes[] = str_replace('!', '', $file);
            } else {
                $excludes[] = $file;
            }
        }

        return array($excludes, $includes);
    }

    private function getExcludeIncludeFromGitignoreParserToBash($base, $file)
    {
        $directory = rtrim(dirname($file), '/');
        $base = str_replace(rtrim($base, '/').'/', '', $directory);

        $excludes = $includes = array();

        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $file) {
            $file = trim($file);

            if (strpos($file, '#') === 0) {
                continue;
            }

            $file = $base.'/'.ltrim($file, '/');

            if (strstr($file, '!')) {
                $includes[] = str_replace('!', '', $file);
            } else {
                $excludes[] = $file;
            }
        }

        return array($excludes, $includes);
    }
}
