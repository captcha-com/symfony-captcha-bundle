<?php

namespace Captcha\Bundle\CaptchaBundle\Support;

use Symfony\Component\HttpKernel\Kernel;

final class Path
{
    /**
     * Disable instance creation.
     */
    private function __construct() {}

    /**
     * Physical path of the captcha-com/captcha package.
     *
     * @return string
     */
    public static function getLibPackageDirPath()
    {
        return __DIR__ . '/../../captcha/';
    }

    /**
     * Physical path of public directory which is located inside the captcha-com/captcha package.
     *
     * @return string
     */
    public static function getPublicDirPathInLibrary()
    {
        return self::getLibPackageDirPath() . 'lib/botdetect/public/';
    }

    /**
     * Physical path of botdetect.php file.
     *
     * @return string
     */
    public static function getBotDetectFilePath()
    {
        return __DIR__ . '/../Provider/botdetect.php';
    }

    /**
     * Physical path of captcha config defaults file.
     *
     * @return string
     */
    public static function getCaptchaConfigDefaultsFilePath()
    {
        return __DIR__ . '/CaptchaConfigDefaults.php';
    }

    /**
     * Physical path of the Symfony's config directory.
     *
     * @param string  $path
     *
     * @return string
     */
    public static function getConfigDirPath($path = '')
    {
        if (Kernel::VERSION < 4) {
            return __DIR__ . '/../../../../app/config' . ($path ? '/' . $path : $path);
        } else {
            return __DIR__ . '/../../../../config/packages' . ($path ? '/' . $path : $path);
        }
    }
}
