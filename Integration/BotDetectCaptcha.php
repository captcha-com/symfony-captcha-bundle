<?php

namespace Captcha\Bundle\CaptchaBundle\Integration;

use Captcha\Bundle\CaptchaBundle\Helpers\BotDetectCaptchaHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BotDetectCaptcha
{
    /**
     * @var object
     */
    private $captcha;

    /*
     * @var object
     */
    private $container;

    /**
     * @var array
     */
    public static $productInfo;

    /**
     * Constructor.
     * 
     * @param ContainerInterface  $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Set captcha configuration and create a Captcha object instance.
     *
     * @param string  $configName
     */
    public function setConfig($configName)
    {
        return $this->getCaptchaInstance(
            $this->container->get('session'),
            $configName
        );
    }

    /**
     * @return bool
     */
    private function captchaInstanceAlreadyCreated()
    {
        return isset($this->captcha);
    }

    /*
     * Get an instance of the Captcha class.
     * 
     * @param SessionInterface  $session
     * @param string            $configName
     * 
     * @return object
     */
    public function getCaptchaInstance(SessionInterface $session = null, $configName = '')
    {
        if (!$this->captchaInstanceAlreadyCreated()) {
            $this->captcha = new BotDetectCaptchaHelper($session, $configName);
        }

        return $this->captcha;
    }

    /**
     * Get BotDetect Symfony CAPTCHA Bundle information.
     *
     * @return array
     */
    public static function getProductInfo()
    {
        return self::$productInfo;
    }
}

// static field initialization
BotDetectCaptcha::$productInfo = array(
    'name' => 'BotDetect 4 PHP Captcha generator integration for the Symfony framework',
    'version' => '4.1.0'
);
