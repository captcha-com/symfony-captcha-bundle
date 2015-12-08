<?php

namespace Captcha\Bundle\CaptchaBundle\Helpers;

use Captcha\Bundle\CaptchaBundle\Helpers\LibraryLoaderHelper;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BotDetectCaptchaHelper
{
    /**
     * @var object
     */
    private $captcha;

    /**
     * Constructor.
     *
     * @param  array  $config
     * 
     * @return void
     */
    public function __construct(SessionInterface $session, array $config)
    {
        // load BotDetect Library
        LibraryLoaderHelper::load($session, $config);

        // create a BotDetect Captcha object instance
        $this->initCaptcha($config);
    }

    /**
     * Initialize CAPTCHA object instance.
     *
     * @param  array  $config
     * 
     * @return void
     */
    public function initCaptcha(array $config)
    {
        // set captchaId and create an instance of Captcha
        if (isset($config['captcha_id'])) {
            $this->captcha = new \Captcha($config['captcha_id']);
        }
        
        // set user's input id
        if (isset($config['user_input_id'])) {
            $this->captcha->UserInputId = $config['user_input_id'];
        }
    }

    public function __call($method, $args = array())
    {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $args);
        }

        if (method_exists($this->captcha, $method)) {
            return call_user_func_array(array($this->captcha, $method), $args);
        }
    }

    /**
     * Auto-magic helpers for civilized property access.
     */
    public function __get($name)
    {
        if (method_exists($this->captcha, ($method = 'get_'.$name))) {
            return $this->captcha->$method();
        }

        if (method_exists($this, ($method = 'get_'.$name))) {
            return $this->$method();
        }
    }

    public function __isset($name)
    {
        if (method_exists($this->captcha, ($method = 'isset_'.$name))) {
            return $this->captcha->$method();
        } 

        if (method_exists($this, ($method = 'isset_'.$name))) {
            return $this->$method();
        }
    }

    public function __set($name, $value)
    {
        if (method_exists($this->captcha, ($method = 'set_'.$name))) {
            $this->captcha->$method($value);
        } else if (method_exists($this, ($method = 'set_'.$name))) {
            $this->$method($value);
        }
    }

    public function __unset($name)
    {
        if (method_exists($this->captcha, ($method = 'unset_'.$name))) {
            $this->captcha->$method();
        } else if (method_exists($this, ($method = 'unset_'.$name))) {
            $this->$method();
        }
    }
}
