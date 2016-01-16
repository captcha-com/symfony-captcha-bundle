<?php

namespace Captcha\Bundle\CaptchaBundle\Support;

use Captcha\Bundle\CaptchaBundle\Support\Exception\FileNotFoundException;
use Captcha\Bundle\CaptchaBundle\Support\Path;

final class UserCaptchaConfiguration
{
    /**
     * Disable instance creation.
     */
    private function __construct() {}

    /**
     * Get user's captcha configuration by captcha id.
     *
     * @param string  $captchaId
     *
     * @return array
     */
    public static function get($captchaId)
    {
        $captchaId = trim($captchaId);

        $captchaIdTemp = strtolower($captchaId);
        $configs = array_change_key_case(self::all(), CASE_LOWER);

        $config = (is_array($configs) && array_key_exists($captchaIdTemp, $configs))
            ? $configs[$captchaIdTemp]
            : null;

        if (is_array($config)) {
            $config['CaptchaId'] = $captchaId;
        }

        return $config;
    }

    /**
     * Get all user's captcha configuration.
     *
     * @return array
     *
     * @throw FileNotFoundException
     */
    public static function all()
    {
        $configPath = Path::getConfigDirPath('captcha.php');

        if (!file_exists($configPath)) {
            throw new FileNotFoundException('File "app/config/captcha.php" could not be found.');
        }

        $captchaConfigs = require $configPath;

        return $captchaConfigs;
    }

    /**
     * Execute user's captcha configuration options.
     *
     * @param \Captcha  $captcha
     * @param array     $config
     * 
     * @return void
     */
    public static function execute(\Captcha $captcha, array $config)
    {
        unset($config['CaptchaId']);
        unset($config['UserInputId']);

        if (empty($config)) {
            return;
        }

        foreach ($config as $option => $value) {
            $captcha->$option = $value;
        }
    }
}
