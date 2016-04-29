<?php
namespace WebDeploy\Command;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

class ClearCompiled
{
    public function run()
    {
        $compiled = WD_VENDOR_PATH.'/compiled.php';

        if (is_file($compiled)) {
            unlink($compiled);
        }
    }
}
