<?php

namespace Captcha\Bundle\CaptchaBundle\Integration;

use Captcha\Bundle\CaptchaBundle\Support\LibraryLoader;
use Captcha\Bundle\CaptchaBundle\Helpers\BotDetectCaptchaHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
        return $this->getInstance($configName);
    }

    /**
     * @return bool
     */
    private function isInstanceCreated()
    {
        return isset($this->captcha);
    }

    /**
     * Get an instance of the Captcha class.
     * 
     * @param string  $configName
     * 
     * @return object
     */
    public function getInstance($configName = '')
    {
        if (!$this->isInstanceCreated()) {
            // load BotDetect Library
            $libraryLoader = new LibraryLoader($this->container);
            $libraryLoader->load();

            $this->captcha = new BotDetectCaptchaHelper($configName);
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
    'version' => '4.2.12'
);
