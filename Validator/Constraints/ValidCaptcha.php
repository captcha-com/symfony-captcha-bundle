<?php

namespace Captcha\Bundle\CaptchaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidCaptcha extends Constraint
{
    /*
     * @var string
     */
    public $message = 'CAPTCHA validation failed, please try again.';

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'valid_captcha';
    }
}
