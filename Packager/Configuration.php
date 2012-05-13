<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\Packager;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Theme package configuration schema.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('theme');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('name')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('author')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('version')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('description')->defaultValue('...')->end()

                ->scalarNode('extends')->end()
            ->end();

        return $treeBuilder;
    }
}
