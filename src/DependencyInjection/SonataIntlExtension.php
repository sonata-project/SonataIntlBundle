<?php

declare(strict_types=1);

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

        if (0 === \count($timezoneDetectors)) {
            // define default values if there is no value defined in configuration.
            $timezoneDetectors = [
                'sonata.intl.timezone_detector.user',
                'sonata.intl.timezone_detector.locale',
            ];
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

        $container->setParameter('sonata_intl.timezone.detectors', $timezoneDetectors);
    }

    protected function configureLocale(ContainerBuilder $container, array $config)
    {
        $container->getDefinition('sonata.intl.locale_detector.request_stack')->replaceArgument(1, $config['locale'] ?: '%kernel.default_locale%');
        $container->setAlias('sonata.intl.locale_detector', 'sonata.intl.locale_detector.request_stack');
    }

    /**
     * Validate timezones.
     *
     * @throws \RuntimeException If one of the locales is invalid
     */
    private function validateTimezones(array $timezones): void
    {
        foreach ($timezones as $timezone) {
            try {
                new \DateTimeZone($timezone);
            } catch (\Exception $e) {
                throw new \RuntimeException(sprintf(
                    'Unknown timezone "%s". Please check your sonata_intl configuration.',
                    $timezone
                ));
            }
        }
    }
}
