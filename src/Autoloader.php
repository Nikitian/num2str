<?php
namespace Nikitian\Num2str;
/**
 * Autoloads Nikitian\Num2str classes
 *
 * @package Nikitian\Num2str
 */
class Autoloader
{
    const PREFIX = 'Nikitian\\Num2str';
    /**
     * Register the autoloader
     */
    public static function register()
    {
        spl_autoload_register(array(new self, 'autoload'));
    }
    /**
     * Autoloader
     *
     * @param string
     */
    public static function autoload($class)
    {
        $prefixLength = strlen(self::PREFIX);
        if (0 === strncmp(self::PREFIX, $class, $prefixLength)) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, substr($class, $prefixLength));
            $file = realpath(__DIR__ . (empty($file) ? '' : DIRECTORY_SEPARATOR) . $file . '.php');
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }
}