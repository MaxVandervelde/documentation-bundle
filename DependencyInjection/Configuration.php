<?php
/**
 * Configuration.php
 *
 * @copyright (c) 2013, Sierra Bravo Corp., dba The Nerdery, All rights reserved
 * @license BSD-2-Clause
 */

namespace Nerdery\DocumentationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nerdery_documentation');

        $rootNode
            ->children()
                ->arrayNode('packages')
                ->defaultValue(array())
                ->useAttributeAsKey('path')
                ->prototype('array')
                ->children()
                    ->scalarNode('index')
                        ->isRequired()
                    ->end()
                    ->scalarNode('title')
                        ->isRequired()
                    ->end()
                ->end()
            ->end();


        return $treeBuilder;
    }
}
