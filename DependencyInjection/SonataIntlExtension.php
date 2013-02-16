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

use Sonata\IntlBundle\SonataIntlBundle;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\Kernel;

/**
 * SonataIntlExtension
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 * @author Alexander <iam.asm89@gmail.com>
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

        if (isset($config['timezone']['service'])) {
            $container->setAlias('sonata.intl.timezone_detector', $config['timezone']['service']);
            $container->removeDefinition('sonata.intl.timezone_detector.default');
        } else {
            $this->validateTimezones($config['timezone']['locales'] + array($config['timezone']['default']));

            $container->setAlias('sonata.intl.timezone_detector', 'sonata.intl.timezone_detector.default');
            $container->getDefinition('sonata.intl.timezone_detector.default')
                ->replaceArgument(1, $config['timezone']['default'])
                ->replaceArgument(2, $config['timezone']['locales']);
        }

        if (version_compare(SonataIntlBundle::getSymfonyVersion(Kernel::VERSION), '2.1.0', '>=')) {
            $container->getDefinition('sonata.intl.locale_detector.request')->replaceArgument(1, $config['locale'] ? $config['locale'] : $container->getParameter('kernel.default_locale'));
            $container->setAlias('sonata.intl.locale_detector', 'sonata.intl.locale_detector.request');
            $container->removeDefinition('sonata.intl.locale_detector.session');
        } else {
            $container->getDefinition('sonata.intl.locale_detector.session')->replaceArgument(1, $config['locale'] ? $config['locale'] : $container->getParameter('session.default_locale'));
            $container->setAlias('sonata.intl.locale_detector', 'sonata.intl.locale_detector.session');
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

    /**
     * Validate timezones
     *
     * @param array $timezones
     *
     * @throws \RuntimeException If one of the locales is invalid
     */
    private function validateTimezones(array $timezones)
    {
        $availableTimezones = \DateTimeZone::listIdentifiers();
        foreach ($timezones as $timezone) {
            if (!in_array($timezone, $availableTimezones)) {
                throw new \RuntimeException(sprintf('Unknown timezone "%s". Please check your sonata_intl configuration.', $timezone));
            }
        }
    }
}
