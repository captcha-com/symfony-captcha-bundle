<?php 

namespace Captcha\Bundle\CaptchaBundle\Validator\Constraints;

use Captcha\Bundle\CaptchaBundle\Helpers\BotDetectCaptchaHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ValidCaptchaValidator extends ConstraintValidator
{
    /**
     * @var object
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        $captcha = $this->container->get('captcha')->getCaptchaInstance();

        if (!$captcha instanceof BotDetectCaptchaHelper) {
            throw new UnexpectedTypeException($captcha, 'Captcha\Bundle\CaptchaBundle\Helpers\BotDetectCaptchaHelper');
        }

        if (!$captcha->Validate($value)) {
            $this->context->addViolation($constraint->message);
        }
    }
}
