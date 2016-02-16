<?php
namespace WebDeploy\Filesystem;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use WebDeploy\Exception;

class Directory
{
    private $directory;
    private $recursive;
    private $filters = array();

    public function __construct($directory)
    {
        if (!is_dir($directory)) {
            throw new Exception\NotFoundException(__('Directory %s not exists', $directory));
        }

        $this->directory = $directory;

        return $this;
    }

    public function recursive($recursive)
    {
        $this->recursive = $recursive;

        return $this;
    }

    public function filterExclude($exclude)
    {
        if (empty($this->filters['exclude'])) {
            $this->filters['exclude'] = array();
        }

        if (is_array($exclude)) {
            $this->filters['exclude'] = array_merge($this->filters['exclude'], $exclude);
        } else {
            $this->filters['exclude'][] = $exclude;
        }

        return $this;
    }

    public function filterInclude($include)
    {
        if (empty($this->filters['include'])) {
            $this->filters['include'] = array();
        }

        if (is_array($include)) {
            $this->filters['include'] = array_merge($this->filters['include'], $include);
        } else {
            $this->filters['include'][] = $include;
        }

        return $this;
    }

    public function filterOnlyFile($boolean)
    {
        $this->filters['onlyFile'] = $boolean;

        return $this;
    }

    public function filterOnlyDirectory($boolean)
    {
        $this->filters['onlyDirectory'] = $boolean;

        return $this;
    }

    public function filterNewer($time)
    {
        $this->filters['newer'] = $this->filterTime($time);

        return $this;
    }

    public function filterOlder($time)
    {
        $this->filters['older'] = $this->filterTime($time);

        return $this;
    }

    private function filterTime($time)
    {
        return preg_match('/^[0-9]+$/', $time) ? $time : strtotime($time);
    }

    public function get()
    {
        return $this->recursive ? $this->scanRecursive() : $this->scan();
    }

    public function scanRecursiveFiltered($filter)
    {
        $directory = new RecursiveDirectoryIterator($this->directory);
        $iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);
        $files = new RegexIterator($iterator, '#'.$filter.'#', RecursiveRegexIterator::GET_MATCH);

        return array_keys(iterator_to_array($files));
    }

    private function scanRecursive()
    {
        $directory = new RecursiveDirectoryIterator($this->directory);
        $iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);

        $this->prepareFilters();

        $files = array();

        foreach ($iterator as $fileinfo) {
            if ($this->passFilters($file = $fileinfo->getPathname())) {
                $files[] = $file;
            }
        }

        return $files;
    }

    private function prepareFilters()
    {
        if (empty($this->filters['include'])) {
            $this->filters['include_prepared'] = '';
        } else {
            $this->filters['include_prepared'] = implode('|', $this->filters['include']);
        }

        if (empty($this->filters['exclude'])) {
            $this->filters['exclude_prepared'] = '';
        } else {
            $this->filters['exclude_prepared'] = implode('|', $this->filters['exclude']);
        }
    }

    private function passFilters($file)
    {
        return $this->isIncluded($file)
            && $this->isOnlyFile($file)
            && $this->isOnlyDirectory($file)
            && $this->isOlder($file)
            && $this->isNewer($file);
    }

    private function isIncluded($file)
    {
        if (preg_match('#/\.+$#', $file)) {
            return false;
        }

        $excluded = $this->isExcluded($file);

        if ($excluded && $this->filters['include_prepared']) {
            return preg_match('#'.$this->filters['include_prepared'].'#', $file);
        }

        return !$excluded;
    }

    private function isExcluded($file)
    {
        if (preg_match('#/\.+$#', $file)) {
            return true;
        }

        if ($this->filters['exclude_prepared']) {
            return preg_match('#'.$this->filters['exclude_prepared'].'#', $file);
        }

        return false;
    }

    private function isOnlyFile($file)
    {
        return (empty($this->filters['onlyFile']) || is_file($file));
    }

    private function isOnlyDirectory($file)
    {
        return (empty($this->filters['onlyDirectory']) || is_dir($file));
    }

    private function isOlder($file)
    {
        return (empty($this->filters['older']) || (filemtime($file) < $this->filters['older']));
    }

    private function isNewer($file)
    {
        return (empty($this->filters['newer']) || (filemtime($file) > $this->filters['newer']));
    }
}
