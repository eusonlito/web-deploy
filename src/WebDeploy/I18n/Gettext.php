<?php
namespace WebDeploy\I18n;

use Gettext\Extractors;
use Gettext\Generators;
use Gettext\Translations;
use Gettext\Translator;
use WebDeploy\Router;

class Gettext
{
    private static $config = array();
    private static $locale;

    public static function setConfig(array $config = array())
    {
        self::$config = $config ?: array(
            'storage' => Router\Route::getBasePath('/application/gettext'),
            'locales' => array('es', 'pt', 'fr'),
            'domain' => 'gettext',
        );
    }

    public static function getFile($locale)
    {
        return sprintf('%s/%s/LC_MESSAGES/%s.', self::$config['storage'], $locale, self::$config['domain']);
    }

    public static function load($code)
    {
        self::setConfig();

        self::$locale = $code;

        $locale = self::$locale.'.UTF-8';

        # IMPORTANT: locale must be installed in server!
        # sudo locale-gen es_ES.UTF-8
        # sudo update-locale

        defined('LC_MESSAGES') or define('LC_MESSAGES', 5);

        putenv('LANG='.$locale);
        putenv('LANGUAGE='.$locale);
        putenv('LC_MESSAGES='.$locale);
        putenv('LC_PAPER='.$locale);
        putenv('LC_TIME='.$locale);
        putenv('LC_MONETARY='.$locale);

        setlocale(LC_MESSAGES, $locale);
        setlocale(LC_COLLATE, $locale);
        setlocale(LC_TIME, $locale);
        setlocale(LC_MONETARY, $locale);

        bindtextdomain(self::$config['domain'], self::$config['storage']);
        bind_textdomain_codeset(self::$config['domain'], 'UTF-8');
        textdomain(self::$config['domain']);

        # Also, we will work with gettext/gettext library
        # because PHP gones crazy when mo files are updated
        $path = dirname(self::getFile(self::$locale));
        $file = $path.'/'.self::$config['domain'];

        if (is_file($file.'.mo')) {
            $translations = Translations::fromMoFile($file.'.mo');
        } elseif (is_file($file.'.po')) {
            $translations = Translations::fromPoFile($file.'.po');
        } else {
            $translations = new Translations();
        }

        $translator = new Translator();

        Translator::initGettextFunctions($translator->loadTranslations($translations));
    }
}
