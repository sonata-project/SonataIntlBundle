<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\IntlBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * SonataIntlExtension.
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 * @author Alexander <iam.asm89@gmail.com>
 */
class SonataIntlExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('autowire.xml');
        $loader->load('intl.xml');

        $this->configureTimezone($container, $config);
        $this->configureLocale($container, $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    protected function configureTimezone(ContainerBuilder $container, array $config)
    {
        if (isset($config['timezone']['service'])) {
            $container->setAlias('sonata.intl.timezone_detector', $config['timezone']['service']);
            $container->removeDefinition('sonata.intl.timezone_detector.default');

            return;
        }

        $this->validateTimezones($config['timezone']['locales'] + [$config['timezone']['default']]);

        $container->setAlias('sonata.intl.timezone_detector', 'sonata.intl.timezone_detector.chain');

        $timezoneDetectors = $config['timezone']['detectors'];

        $bundles = $container->getParameter('kernel.bundles');

        if (0 == count($timezoneDetectors)) { // no value define in the configuration, set one
            // Support Sonata User Bundle.
            if (isset($bundles['SonataUserBundle'])) {
                $timezoneDetectors[] = 'sonata.intl.timezone_detector.user';
            }

            $timezoneDetectors[] = 'sonata.intl.timezone_detector.locale';
        }

        foreach ($timezoneDetectors as $id) {
            $container
                ->getDefinition('sonata.intl.timezone_detector.chain')
                ->addMethodCall('addDetector', [new Reference($id)]);
        }

        $container
            ->getDefinition('sonata.intl.timezone_detector.locale')
            ->replaceArgument(1, $config['timezone']['locales'])
        ;

        $container
            ->getDefinition('sonata.intl.timezone_detector.chain')
            ->replaceArgument(0, $config['timezone']['default'])
        ;

        if (!isset($bundles['SonataUserBundle'])) {
            $container->removeDefinition('sonata.intl.timezone_detector.user');
        } else {
            // support Symfony2.6+
            $container->getDefinition('sonata.intl.timezone_detector.user')
                ->replaceArgument(0, new Reference(interface_exists('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface')
                    ? 'security.token_storage' : 'security.context'));
        }

        $container->setParameter('sonata_intl.timezone.detectors', $timezoneDetectors);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    protected function configureLocale(ContainerBuilder $container, array $config)
    {
        if (class_exists('Symfony\Component\HttpFoundation\RequestStack')) {
            $container->getDefinition('sonata.intl.locale_detector.request_stack')->replaceArgument(1, $config['locale'] ? $config['locale'] : $container->getParameter('kernel.default_locale'));
            $container->setAlias('sonata.intl.locale_detector', 'sonata.intl.locale_detector.request_stack');
            $container->removeDefinition('sonata.intl.locale_detector.session');
            $container->removeDefinition('sonata.intl.locale_detector.request');
        } elseif (method_exists('Symfony\Component\HttpFoundation\Request', 'getLocale')) {
            $container->getDefinition('sonata.intl.locale_detector.request')->replaceArgument(1, $config['locale'] ? $config['locale'] : $container->getParameter('kernel.default_locale'));
            $container->setAlias('sonata.intl.locale_detector', 'sonata.intl.locale_detector.request');
            $container->removeDefinition('sonata.intl.locale_detector.session');
            $container->removeDefinition('sonata.intl.locale_detector.request_stack');
        } else {
            $container->getDefinition('sonata.intl.locale_detector.session')->replaceArgument(1, $config['locale'] ? $config['locale'] : $container->getParameter('session.default_locale'));
            $container->setAlias('sonata.intl.locale_detector', 'sonata.intl.locale_detector.session');
            $container->removeDefinition('sonata.intl.locale_detector.request');
            $container->removeDefinition('sonata.intl.locale_detector.request_stack');
        }
    }

    /**
     * Validate timezones.
     *
     * @param array $timezones
     *
     * @throws \RuntimeException If one of the locales is invalid
     */
    private function validateTimezones(array $timezones)
    {
        try {
            foreach ($timezones as $timezone) {
                $tz = new \DateTimeZone($timezone);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException(sprintf('Unknown timezone "%s". Please check your sonata_intl configuration.', $timezone));
        }
    }
}
