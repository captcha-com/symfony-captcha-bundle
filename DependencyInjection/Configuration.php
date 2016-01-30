<?php

namespace Captcha\Bundle\CaptchaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('captcha');

        $rootNode
            ->children()
                ->variableNode('captchaConfig')->defaultValue(null)->end()
                ->booleanNode('addLayoutStylesheetInclude')->defaultTrue()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
