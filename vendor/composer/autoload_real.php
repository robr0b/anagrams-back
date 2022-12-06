<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit62d912d0d02c1cfc0b004a59d54d994f
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

        spl_autoload_register(array('ComposerAutoloaderInit62d912d0d02c1cfc0b004a59d54d994f', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit62d912d0d02c1cfc0b004a59d54d994f', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit62d912d0d02c1cfc0b004a59d54d994f::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}