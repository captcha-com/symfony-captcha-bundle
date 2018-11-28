<?php

namespace Captcha\Bundle\CaptchaBundle\Helpers;

use Captcha\Bundle\CaptchaBundle\Support\LibraryLoader;
use Captcha\Bundle\CaptchaBundle\Routing\Generator\UrlGenerator;
use Captcha\Bundle\CaptchaBundle\Support\UserCaptchaConfiguration;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BotDetectCaptchaHelper
{
    /**
     * @var object
     */
    private $captcha;

    /**
     * Constructor.
     *
     * @param  string  $configName
     *
     * @return void
     */
    public function __construct($configName, $captchaInstanceId = null)
    {
        // get captcha config
        $captchaId = $configName;
        $config = UserCaptchaConfiguration::get($captchaId);

        if (null === $config) {
            throw new InvalidArgumentException(sprintf('The "%s" option could not be found in app/config/captcha.php file.', $captchaId));
        }

        if (!is_array($config)) {
            throw new UnexpectedTypeException($config, 'array');
        }

        // save user's captcha configuration options
        UserCaptchaConfiguration::save($config);

        // create a BotDetect Captcha object instance
        $this->initCaptcha($config, $captchaInstanceId);
    }

    /**
     * Initialize CAPTCHA object instance.
     *
     * @param  array  $config
     * 
     * @return void
     */
    public function initCaptcha(array $config, $captchaInstanceId = null)
    {
        // set captchaId and create an instance of Captcha
        $captchaId = (array_key_exists('CaptchaId', $config)) ? $config['CaptchaId'] : 'defaultCaptchaId';
        $this->captcha = new \Captcha($captchaId, $captchaInstanceId);

        // set user's input id
        if (array_key_exists('UserInputID', $config)) {
            $this->captcha->UserInputID = $config['UserInputID'];
        }
    }

    /**
     * Override Captcha's Html method.
     * Add stylesheet css into Captcha html markup.
     */
    public function Html()
    {
        $captchaUrlGenerator = UrlGenerator::getInstance();
        $html  = \BDC_HtmlHelper::StylesheetInclude($captchaUrlGenerator->generate('captcha_handler', array(), UrlGeneratorInterface::RELATIVE_PATH) . '?get=bdc-layout-stylesheet.css');
        $html .= $this->captcha->Html();
        return $html;
    }

    public function __call($method, $args = array())
    {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $args);
        }

        if (method_exists($this->captcha, $method)) {
            return call_user_func_array(array($this->captcha, $method), $args);
        }

        if (method_exists($this->captcha->get_CaptchaBase(), $method)) {
            return call_user_func_array(array($this->captcha->get_CaptchaBase(), $method), $args);
        }
    }

    /**
     * Auto-magic helpers for civilized property access.
     */
    public function __get($name)
    {
        if (method_exists($this->captcha->get_CaptchaBase(), ($method = 'get_'.$name))) {
          return $this->captcha->get_CaptchaBase()->$method();
        }

        if (method_exists($this->captcha, ($method = 'get_'.$name))) {
            return $this->captcha->$method();
        }

        if (method_exists($this, ($method = 'get_'.$name))) {
            return $this->$method();
        }
    }

    public function __isset($name)
    {
        if (method_exists($this->captcha->get_CaptchaBase(), ($method = 'isset_'.$name))) {
            return $this->captcha->get_CaptchaBase()->$method();
        }

        if (method_exists($this->captcha, ($method = 'isset_'.$name))) {
            return $this->captcha->$method();
        } 

        if (method_exists($this, ($method = 'isset_'.$name))) {
            return $this->$method();
        }
    }

    public function __set($name, $value)
    {
        if (method_exists($this->captcha->get_CaptchaBase(), ($method = 'set_'.$name))) {
            return $this->captcha->get_CaptchaBase()->$method($value);
        }

        if (method_exists($this->captcha, ($method = 'set_'.$name))) {
            $this->captcha->$method($value);
        } else if (method_exists($this, ($method = 'set_'.$name))) {
            $this->$method($value);
        }
    }

    public function __unset($name)
    {
        if (method_exists($this->captcha->get_CaptchaBase(), ($method = 'unset_'.$name))) {
            return $this->captcha->get_CaptchaBase()->$method();
        }

        if (method_exists($this->captcha, ($method = 'unset_'.$name))) {
            $this->captcha->$method();
        } else if (method_exists($this, ($method = 'unset_'.$name))) {
            $this->$method();
        }
    }
}
