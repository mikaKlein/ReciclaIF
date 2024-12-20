<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit57400f2210f529585e5dfc530f290497
{
    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/../..' . '/src',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->fallbackDirsPsr4 = ComposerStaticInit57400f2210f529585e5dfc530f290497::$fallbackDirsPsr4;
            $loader->classMap = ComposerStaticInit57400f2210f529585e5dfc530f290497::$classMap;

        }, null, ClassLoader::class);
    }
}
