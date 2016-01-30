<?php

namespace Captcha\Bundle\CaptchaBundle\Support;

use Captcha\Bundle\CaptchaBundle\Support\Path;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class LibraryLoader
{
    /**
     * Disable instance creation.
     */
    private function __construct() {}

    /**
     * Load BotDetect CAPTCHA Library and override Captcha Library settings.
     *
     * @param SessionInterface  $session
     */
    public static function load(SessionInterface $session)
    {
        // load bd php library
        self::loadBotDetectLibrary();

        // load the captcha configuration defaults
        self::loadCaptchaConfigDefaults($session);
    }

    /**
     * Load BotDetect CAPTCHA Library.
     */
    private static function loadBotDetectLibrary()
    {
        self::includeFile(Path::getBotDetectFilePath(), true);
    }

    /**
     * Load the captcha configuration defaults.
     *
     * @param SessionInterface  $session
     */
    private static function loadCaptchaConfigDefaults(SessionInterface $session)
    {
        self::includeFile(Path::getCaptchaConfigDefaultsFilePath(), true, $session);
    }

    /**
     * Include a file.
     *
     * @param string  $filePath
     * @param bool    $once
     * @param string  $includeData
     */
    private static function includeFile($filePath, $once = false, $includeData = null)
    {
        if (is_file($filePath)) {
            ($once) ? include_once($filePath) : include($filePath);
        }
    }
}
