<?php 

namespace Captcha\Bundle\CaptchaBundle\Validator\Constraints;

use Captcha\Bundle\CaptchaBundle\Helpers\BotDetectSimpleCaptchaHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ValidSimpleCaptchaValidator extends ConstraintValidator
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
        $captcha = $this->container->get('simple_captcha')->getInstance();

        if (!$captcha instanceof BotDetectSimpleCaptchaHelper) {
            throw new UnexpectedTypeException($captcha, 'Captcha\Bundle\CaptchaBundle\Helpers\BotDetectSimpleCaptchaHelper');
        }

        if (!$captcha->Validate($value)) {
            $this->context->addViolation($constraint->message);
        }
    }
}
