<?php
namespace Brainteaser\InfrastructureBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class BrainteaserInfrastructureExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services/domain.xml');
        $loader->load('services/application.xml');
        $loader->load('services/services.xml');
        $loader->load('services/repository.xml');
        $loader->load('services/controller.xml');
    }
}
