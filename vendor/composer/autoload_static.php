<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit00da1f11a37cff960263beb4d8056d39
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Inmoob\\WPB_Components\\' => 22,
            'Inmoob\\Shortcodes\\' => 18,
            'Inmoob\\Config\\' => 14,
            'Inmoob\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Inmoob\\WPB_Components\\' => 
        array (
            0 => __DIR__ . '/../..' . '/plugins-support/js_composer/Components',
        ),
        'Inmoob\\Shortcodes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Shortcodes',
        ),
        'Inmoob\\Config\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Config',
        ),
        'Inmoob\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Core',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit00da1f11a37cff960263beb4d8056d39::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit00da1f11a37cff960263beb4d8056d39::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}