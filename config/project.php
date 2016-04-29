<?php
return array(
    'modules' => array('git', 'ftp', 'rsync', 'phpinfo', 'admin'),
    'path' => realpath(WD_BASE_PATH.'/..'),
    'www' => dirname(dirname(getenv('SCRIPT_NAME')))
);
