<?php

namespace Captcha\Bundle\CaptchaBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class CaptchaExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // load services
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yml');

        // set captcha configuration
        $configuration = new Configuration($configs);
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('captcha.config', $config);
        $container->setParameter('captcha.config.captchaConfig', $config['captchaConfig']);

        foreach ($config as $page => $captchaConfig) {
            if (is_array($captchaConfig)) {
                $this->setParameterSection($container, $page, $captchaConfig);
            }
        }

        // set captcha template
        $resources = $container->getParameter('twig.form.resources');
        $container->setParameter(
            'twig.form.resources',
            array_merge(array('CaptchaBundle::captcha.html.twig'), $resources)
        );
    }

    /*
     * Set parameter of user's captcha configuration.
     * 
     * @param ContainerBuilder  $container
     * @param string            $page
     * @param array             $captchaConfig
     * 
     * @return void
     */
    public function setParameterSection(ContainerBuilder $container, $page, array $captchaConfig)
    {
        $container->setParameter(
            'captcha.config.' . $page,
            $captchaConfig
        );

        $container->setParameter(
            'captcha.config.' . $page . '.captcha_id',
            $captchaConfig['captcha_id']
        );

        $container->setParameter(
            'captcha.config.' . $page . '.user_input_id',
            $captchaConfig['user_input_id']
        );

        $container->setParameter(
            'captcha.config.' . $page . '.captcha_config_file_path',
            $captchaConfig['captcha_config_file_path']
        );
    }
}
