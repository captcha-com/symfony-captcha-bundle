<?php

namespace Captcha\Bundle\CaptchaBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;

class CaptchaRoutesLoader extends Loader
{
    /**
     * {@inheritdoc}
     */
    public function load($routingResource, $type = null)
    {
        $collection = new RouteCollection();

        $routingResource = '@CaptchaBundle/Resources/config/routing.yml';
        $type = 'yaml';

        $importedRoutes = $this->import($routingResource, $type);

        $collection->addCollection($importedRoutes);

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return 'captcha_routes' === $type;
    }
}
