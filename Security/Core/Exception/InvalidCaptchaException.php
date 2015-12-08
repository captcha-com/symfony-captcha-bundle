<?php

namespace Captcha\Bundle\CaptchaBundle\Security\Core\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * This exception is thrown when CAPTCHA validation failed on login form.
 */
class InvalidCaptchaException extends AuthenticationException
{
    /**
     * @var string
     */
    protected $message = 'CAPTCHA validation failed, please try again.';

    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return $this->message;
    }
}
