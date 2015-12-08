<?php

namespace Captcha\Bundle\CaptchaBundle\Routing\Generator;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator as SymfonyUrlGenerator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RequestContext;

class UrlGenerator
{
    /**
     * Get an object instance of UrlGenerator class.
     * 
     * @return UrlGenerator
     */
    public static function getInstance()
    {
        $configDirectory = new YamlFileLoader(
            new FileLocator(array(__DIR__ . '/../../Resources/config'))
        );

        $captchaRoutes = $configDirectory->load('routing.yml');

        $requestContext = new RequestContext();
        $requestContext->fromRequest(Request::createFromGlobals());

        return new SymfonyUrlGenerator($captchaRoutes, $requestContext);
    }
}
