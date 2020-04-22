<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit25fc253144c60c5251231aaaea623594
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit25fc253144c60c5251231aaaea623594::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit25fc253144c60c5251231aaaea623594::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
