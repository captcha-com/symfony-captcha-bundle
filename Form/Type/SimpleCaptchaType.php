<?php

namespace Captcha\Bundle\CaptchaBundle\Form\Type;

use Captcha\Bundle\CaptchaBundle\Support\Path;
use Captcha\Bundle\CaptchaBundle\Helpers\BotDetectSimpleCaptchaHelper;
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

class SimpleCaptchaType extends AbstractType
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
        $captchaStyleName = !isset($options['captchaStyleName']) ? '' : $options['captchaStyleName'];

        $this->captcha = $this->container->get('simple_captcha')->getInstance($captchaStyleName);

        if (!$this->captcha instanceof BotDetectSimpleCaptchaHelper) {
            throw new UnexpectedTypeException($this->captcha, 'Captcha\Bundle\CaptchaBundle\Helpers\BotDetectSimpleCaptchaHelper');
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
        return 'simple_captcha';
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
