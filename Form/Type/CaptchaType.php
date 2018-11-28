<?php

namespace Captcha\Bundle\CaptchaBundle\Form\Type;

use Captcha\Bundle\CaptchaBundle\Support\Path;
use Captcha\Bundle\CaptchaBundle\Helpers\BotDetectCaptchaHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CaptchaType extends AbstractType
{
    /**
     * @var object
     */
    private $captcha;

    /**
     * @var object
     */
    private $container;

    /**
     * @var array 
     */
    public $options;

    /**
     * {@inheritdoc}
     */
    public function __construct(ContainerInterface $container, array $options)
    {
        $this->container = $container;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults($this->options);
    }

    // BC for SF < 2.7
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!isset($options['captchaConfig']) || '' === $options['captchaConfig']) {
            $path = Path::getRelativeConfigFilePath('captcha.php');
            $errorMessage  = 'The Captcha field type requires you to declare the "captchaConfig" option and assigns a captcha configuration key that defined in ' . $path . ' file. ';
            $errorMessage .= 'For example: $builder->add(\'captchaCode\', CaptchaType::class, array(\'captchaConfig\' => \'LoginCaptcha\'))';
            throw new InvalidArgumentException($errorMessage);
        }

        $this->captcha = $this->container->get('captcha')->setConfig($options['captchaConfig']);

        if (!$this->captcha instanceof BotDetectCaptchaHelper) {
            throw new UnexpectedTypeException($this->captcha, 'Captcha\Bundle\CaptchaBundle\Helpers\BotDetectCaptchaHelper');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['captcha_html'] = $this->captcha->Html();
        $view->vars['user_input_id'] = $this->captcha->UserInputID;
    }

    // BC for SF < 3.0
    public function getName()
    {
        return 'captcha';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        if (version_compare(Kernel::VERSION, '2.8', '<')) {
            return 'text';
        }

        return 'Symfony\Component\Form\Extension\Core\Type\TextType';
    }
}
