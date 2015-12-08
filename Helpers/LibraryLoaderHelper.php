<?php

namespace Captcha\Bundle\CaptchaBundle\Helpers;

use Captcha\Bundle\CaptchaBundle\Config\Path;
use Captcha\Bundle\CaptchaBundle\Config\UserCaptchaConfiguration;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class LibraryLoaderHelper
{
    /**
     * Disable instance creation.
     */
    private function __construct() {}

    /**
     * Load BotDetect CAPTCHA Library and override Captcha Library settings.
     *
     * @param SessionInterface  $session
     * @param array             $config
     */
    public static function load(SessionInterface $session, array $config)
    {
        // load bd php library
        self::loadBotDetectLibrary();

        // load the captcha configuration defaults
        self::loadCaptchaConfigDefaults($session);

        // load user's captcha config
        self::loadUserCaptchaConfig($session, $config);
    }

    /**
     * Load BotDetect CAPTCHA Library.
     *
     * @param SessionInterface  $session
     */
    private static function loadBotDetectLibrary()
    {
        self::includeFile(Path::getBotDetectFilePathInLibrary(), true);
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
     * Load user's captcha configuration.
     *
     * @param SessionInterface  $session
     * @param array             $config
     */
    private static function loadUserCaptchaConfig(SessionInterface $session, array $config)
    {
        $userConfig = new UserCaptchaConfiguration($session);

        // store user's captcha config file path
        if (isset($config['captcha_id']) &&
            isset($config['captcha_config_file_path'])
        ) {
            $userConfig->storePath($config['captcha_id'], $config['captcha_config_file_path']);
        }

        $configFilePath = $userConfig->getPhysicalPath();
        self::includeFile($configFilePath);
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
