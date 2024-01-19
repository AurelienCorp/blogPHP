<?php

class Autoloader
{
    public static function register()
    {
        spl_autoload_register([self::class, 'autoload']);
    }

    public static function autoload($className)
    {
        $filePath = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

        $fullPath = __DIR__ . '/src/' . $filePath;

        if (file_exists($fullPath)) {
            require_once $fullPath;
        }
    }
}
