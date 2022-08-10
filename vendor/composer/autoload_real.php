<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitffc30d19d2305f7ae08bfea4d4588a7c
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitffc30d19d2305f7ae08bfea4d4588a7c', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitffc30d19d2305f7ae08bfea4d4588a7c', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitffc30d19d2305f7ae08bfea4d4588a7c::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
