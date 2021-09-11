<?php
declare(strict_types=1);

namespace RZ\Roadiz\RozierBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder('roadiz_rozier');
        $root = $builder->getRootNode();
        return $builder;
    }
}
