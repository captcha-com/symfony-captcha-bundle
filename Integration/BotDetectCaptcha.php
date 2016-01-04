<?php

namespace Captcha\Bundle\CaptchaBundle\Integration;

use Captcha\Bundle\CaptchaBundle\Helpers\BotDetectCaptchaHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

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
        if (!$this->container->hasParameter($configName)) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $configName));
        }

        $captchaConfig = $this->container->getParameter($configName);

        if (!is_array($captchaConfig)) {
            throw new UnexpectedTypeException($captchaConfig, 'array');
        }

        return $this->getCaptchaInstance(
            $this->container->get('session'),
            $captchaConfig
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
     * @param array             $config
     * 
     * @return object
     */
    public function getCaptchaInstance(SessionInterface $session = null, array $config = array())
    {
        if (!$this->captchaInstanceAlreadyCreated()) {
            $this->captcha = new BotDetectCaptchaHelper($session, $config);
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
    'name' => 'BotDetect PHP Captcha integration for the Symfony framework',
    'version' => '3.3.2'
);
