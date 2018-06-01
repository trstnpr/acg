<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4c3174ac4bf370c3acc8c379bef0ab9a
{
    public static $files = array (
        'decc78cc4436b1292c6c0d151b19445c' => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'p' => 
        array (
            'phpseclib\\' => 10,
        ),
        'A' => 
        array (
            'AceIDE\\Editor\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'phpseclib\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib',
        ),
        'AceIDE\\Editor\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'TQ\\Git' => 
            array (
                0 => __DIR__ . '/..' . '/teqneers/php-stream-wrapper-for-git/src/TQ',
            ),
        ),
        'P' => 
        array (
            'PHPParser' => 
            array (
                0 => __DIR__ . '/..' . '/nikic/php-parser/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4c3174ac4bf370c3acc8c379bef0ab9a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4c3174ac4bf370c3acc8c379bef0ab9a::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit4c3174ac4bf370c3acc8c379bef0ab9a::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
