<?php

namespace Captcha\Bundle\CaptchaBundle\Integration;

use Captcha\Bundle\CaptchaBundle\Helpers\BotDetectSimpleCaptchaHelper;
use Captcha\Bundle\CaptchaBundle\Support\SimpleLibraryLoader;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BotDetectSimpleCaptcha
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
     * Constructor.
     * 
     * @param ContainerInterface  $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return bool
     */
    private function isInstanceCreated()
    {
        return isset($this->captcha);
    }

    /**
     * Get an instance of the SimpleCaptcha class.
     * 
     * @param string  $captchaStyleName
     * 
     * @return object
     */
    public function getInstance($captchaStyleName = '')
    {
        if (!$this->isInstanceCreated()) {
            // load BotDetect Library
            $libraryLoader = new SimpleLibraryLoader($this->container);
            $libraryLoader->load();

            $this->captcha = new BotDetectSimpleCaptchaHelper($captchaStyleName);
        }

        return $this->captcha;
    }

}
