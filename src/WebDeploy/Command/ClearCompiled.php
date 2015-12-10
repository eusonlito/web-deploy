<?php
namespace WebDeploy\Command;

use RecursiveDirectoryIterator, RecursiveIteratorIterator, RecursiveRegexIterator, RegexIterator;

class ClearCompiled
{
    public function run()
    {
        $compiled = WD_LIBS_PATH.'/compiled.php';

        if (is_file($compiled)) {
            unlink($compiled);
        }
    }
}
