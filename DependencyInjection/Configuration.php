<?php

namespace Captcha\Bundle\CaptchaBundle\DependencyInjection;

use Captcha\Bundle\CaptchaBundle\Support\Path;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $captchaLibPathDefault = Path::getDefaultLibPackageDirPath();

        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('captcha');

        $rootNode
            ->children()
                ->variableNode('lib_path')->defaultValue($captchaLibPathDefault)->end()
                ->variableNode('captchaConfig')->defaultValue(null)->end()
                ->variableNode('captchaStyleName')->defaultValue(null)->end()
                ->booleanNode('addLayoutStylesheetInclude')->defaultTrue()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
