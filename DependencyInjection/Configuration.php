<?php

namespace Captcha\Bundle\CaptchaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @var array 
     */
    public $configs;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $configs)
    {
        $this->configs = $configs;
    }

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
            ->end()
        ;

        foreach ($this->configs[0] as $page => $captchaConfig) {
            $this->addCaptchaConfigSection($rootNode, $page, $captchaConfig);
        }

        return $treeBuilder;
    }

    /*
     * Add user captcha configuration to root node.
     * 
     * @param ArrayNodeDefinition   $rootNode
     * @param string                $page
     * @param array                 $captchaConfig
     */
    public function addCaptchaConfigSection(ArrayNodeDefinition $rootNode, $page, array $captchaConfig)
    {
        $captchaId = isset($captchaConfig['captcha_id']) 
            ? $captchaConfig['captcha_id']
            : 'defaultCaptcha';

        $userInputId = isset($captchaConfig['user_input_id']) 
            ? $captchaConfig['user_input_id']
            : 'captchaCode';

        $captchaConfigFilePath = isset($captchaConfig['captcha_config_file_path']) 
            ? $captchaConfig['captcha_config_file_path']
            : null;

        $rootNode
            ->children()
                ->arrayNode($page)
                    ->children()
                        ->scalarNode('captcha_id')->defaultValue($captchaId)->end()
                        ->scalarNode('user_input_id')->defaultValue($userInputId)->end()
                        ->scalarNode('captcha_config_file_path')->defaultValue($captchaConfigFilePath)->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
