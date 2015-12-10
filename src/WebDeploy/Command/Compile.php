<?php
namespace WebDeploy\Command;

use RecursiveDirectoryIterator, RecursiveIteratorIterator, RecursiveRegexIterator, RegexIterator;

class Compile
{
    public function run($arguments)
    {
        $compiled = WD_LIBS_PATH.'/compiled.php';

        if (is_file($compiled)) {
            unlink($compiled);
        }

        $code = '<?php';

        foreach ($this->getfilesRecursive(WD_LIBS_PATH) as $file) {
            $code .= $this->getFileCode($file);
        }

        file_put_contents($compiled, trim($code));
    }

    private function getFilesRecursive($dir)
    {
        clearstatcache(true);

        $directory = new RecursiveDirectoryIterator($dir);
        $iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);
        $files = new RegexIterator($iterator, '/^.+\.php$/', RecursiveRegexIterator::GET_MATCH);

        return array_keys(iterator_to_array($files));
    }

    private function getFileCode($file)
    {
        $code = "\n".str_replace('<?php', '', file_get_contents($file))."\n";

        if (preg_match("/\nnamespace /", $code)) {
            return preg_replace("/\nnamespace\s+([^;]+);/", "\nnamespace $1 {", $code)."}\n";
        }
    }
}
