<?php

declare(strict_types=1);

namespace RZ\Roadiz\RozierBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class RoadizRozierExtension extends Extension
{
    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__) . '/../config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('roadiz_rozier.backoffice_menu_configuration', $config['entries']);
        $container->setParameter('roadiz_rozier.node_form.class', $config['node_form']);
        $container->setParameter('roadiz_rozier.add_node_form.class', $config['add_node_form']);
    }
}
