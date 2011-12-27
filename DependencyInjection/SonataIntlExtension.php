<?php
/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Sonata\IntlBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\Kernel;

/**
 * PageExtension
 *
 *
 * @author     Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class SonataIntlExtension extends Extension
{

    /**
     * Loads the url shortener configuration.
     *
     * @param array            $config    An array of configuration settings
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('intl.xml');

        try {
            new \DateTimeZone($config['timezone']);
        } catch(\Exception $e) {
            throw new \RuntimeException(sprintf('Unable to create a valid DatetimeZone, please check the sonata_intl configuration! (%s)', $e->getMessage()));
        }

        $datetimeZone = new Definition('DateTimeZone', array($config['timezone']));
        $datetimeZone->setPublic(false);

        $container->getDefinition('sonata.intl.templating.helper.datetime')->replaceArgument(0, $datetimeZone);

        if (version_compare(Kernel::VERSION, '2.1.0-DEV', '>=')) {
            $container->getDefinition('sonata.intl.templating.helper.locale')->replaceArgument(1, new Reference('sonata.intl.locale_detector.request'));
            $container->getDefinition('sonata.intl.templating.helper.number')->replaceArgument(1, new Reference('sonata.intl.locale_detector.request'));
            $container->getDefinition('sonata.intl.templating.helper.datetime')->replaceArgument(2, new Reference('sonata.intl.locale_detector.request'));

            $container->getDefinition('sonata.intl.locale_detector.request')->replaceArgument(1, $config['locale'] ? $config['locale'] : $container->getParameter('kernel.default_locale'));

            $container->removeDefinition('sonata.intl.locale_detector.session');
        } else {
            $container->getDefinition('sonata.intl.templating.helper.locale')->replaceArgument(1, new Reference('sonata.intl.locale_detector.session'));
            $container->getDefinition('sonata.intl.templating.helper.number')->replaceArgument(1, new Reference('sonata.intl.locale_detector.session'));
            $container->getDefinition('sonata.intl.templating.helper.datetime')->replaceArgument(2, new Reference('sonata.intl.locale_detector.session'));

            $container->getDefinition('sonata.intl.locale_detector.session')->replaceArgument(1, $config['locale'] ? $config['locale'] : $container->getParameter('session.default_locale'));
            $container->removeDefinition('sonata.intl.locale_detector.request');
        }
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return 'http://www.sonata-project.org/schema/dic/intl';
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return "sonata_intl";
    }
}