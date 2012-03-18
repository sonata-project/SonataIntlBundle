<?php

namespace Sonata\IntlBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 * @author Alexander <iam.asm89@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sonata_intl');

        $rootNode
            ->children()
                ->scalarNode('locale')->defaultValue(false)->end()
                ->arrayNode('timezone')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('service')->end()
                        ->scalarNode('default')->defaultValue(date_default_timezone_get())->end()
                        ->arrayNode('locales')
                            ->defaultValue(array())
                            ->useAttributeAsKey('name')
                            ->prototype('scalar')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
