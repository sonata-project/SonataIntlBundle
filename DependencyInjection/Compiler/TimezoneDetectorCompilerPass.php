<?php
/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\IntlBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * TimezoneDetectorCompilerPass Class
 *
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
class TimezoneDetectorCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $chainTimezoneDetector = $container->getDefinition('sonata.intl.timezone_detector.chain');

        $timezoneDetectors = $container->findTaggedServiceIds('sonata_intl.timezone_detector');
        $timezoneDetectorAliases = $container->getParameter('sonata_intl.timezone.detectors');

        foreach ($timezoneDetectorAliases as $timezoneDetectorAlias) {
            foreach ($timezoneDetectors as $id => $tags) {
                foreach ($tags as $attributes) {
                    if ($attributes['alias'] === $timezoneDetectorAlias) {
                        $chainTimezoneDetector->addMethodCall('addTimezoneDetector', array(new Reference($id), $attributes['alias']));
                    }
                }
            }
        }
    }
}

