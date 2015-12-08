<?php

namespace Captcha\Bundle\CaptchaBundle\Config;

class UserCaptchaConfigFilePath
{
    /**
     * @var string
     */
    private $captchaId;

    /**
     * @var string
     */
    private $captchaConfigFilePath;

    /**
     * Constructor.
     *
     * @param string  $captchaId
     * @param string  $captchaConfigFilePath
     * 
     * @return void
     */
    public function __construct($captchaId, $captchaConfigFilePath)
    {
        $this->captchaId = $captchaId;
        $this->captchaConfigFilePath = $captchaConfigFilePath;
    }

    /**
     * Get Captcha Id.
     *
     * @return string
     */
    public function getCaptchaId()
    {
        return $this->captchaId;
    }

    /**
     * Get user's captcha config file path.
     *
     * @return string
     */
    public function getCaptchaConfigFilePath()
    {
        return $this->captchaConfigFilePath;
    }
}
