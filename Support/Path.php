<?php

namespace Captcha\Bundle\CaptchaBundle\Support;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class Path
{
    /**
     * Disable instance creation.
     */
    private function __construct() {}

    /**
     * Physical path of the captchal library package. 
     * 
     * @param ContainerInterface  $container
     */
    public static function getCaptchaLibPath(ContainerInterface $container)
    {
        $libPath = $container->getParameter('captcha.config.botdetect_captcha_path');
        $libPath = rtrim($libPath, '/');
        return $libPath;
    }

    /**
     * Physical path of the captcha-com/captcha package.
     *
     * @return string
     */
    public static function getDefaultLibPackageDirPath()
    {
        $libPath1 = __DIR__ . '/../../captcha/botdetect-captcha-lib';
        $libPath2 = __DIR__ . '/../../captcha/lib';

        if (is_dir($libPath1)) {
            return $libPath1;
        }

        if (is_dir($libPath2)) {
            return $libPath2;
        }

        return null;
    }

    /**
     * Physical path of public directory which is located inside the captcha package.
     *
     * @return string
     */
    public static function getPublicDirPathInLibrary(ContainerInterface $container)
    {
        return self::getCaptchaLibPath($container) . '/botdetect/public/';
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
     * Physical path of simple-botdetect.php file.
     *
     * @return string
     */
    public static function getSimpleBotDetectFilePath()
    {
        return __DIR__ . '/../Provider/simple-botdetect.php';
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
     * Relative path of user's captcha config file.
     *
     * @return string
     */
    public static function getRelativeConfigFilePath($file = '')
    {
        if (version_compare(Kernel::VERSION, '4.0', '>=')) {
            $configDirPath = 'config/packages/';
        } else {
            $configDirPath = 'app/config/';
        }
        return $configDirPath . $file;
    }

    /**
     * Physical path of the Symfony's config directory.
     *
     * @param string  $path
     *
     * @return string
     */
    public static function getConfigDirPath($file = '')
    {  
        return __DIR__ . '/../../../../'. self::getRelativeConfigFilePath($file);
    }
}
