<?php

namespace Captcha\Bundle\CaptchaBundle\Config\Exception;

/**
 * Exception class thrown when a file couldn't be found.
 */
class FileNotFoundException extends \RuntimeException implements ExceptionInterface
{
    /**
     * {@inheritdoc}
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null, $path = null)
    {
        if (is_null($message)) {
            if (is_null($path)) {
                $message = 'File could not be found.';
            } else {
                $message = sprintf('File "%s" could not be found.', $path);
            }
        }

        parent::__construct($message, $code, $previous);
    }
}
