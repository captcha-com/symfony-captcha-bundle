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
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('captcha.config', $config);
        $container->setParameter('captcha.config.botdetect_captcha_path', $config['botdetect_captcha_path']);
        $container->setParameter('captcha.config.captchaConfig', $config['captchaConfig']);
        $container->setParameter('captcha.config.captchaStyleName', $config['captchaStyleName']);

        // set captcha template
        $resources = $container->getParameter('twig.form.resources');
        $container->setParameter(
            'twig.form.resources',
            array_merge(array('@Captcha/captcha.html.twig'), $resources)
        );
    }
}
