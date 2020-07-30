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

namespace Sonata\IntlBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * NEXT_MAJOR: remove this class.
 *
 * @deprecated since sonata-project/intl-bundle 2.8, to be removed in version 3.0.
 */
final class StrictPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('sonata.intl.locale_detector.request')) {
            return;
        }

        $requestDetector = $container->getDefinition('sonata.intl.locale_detector.request');
        $requestDetector->replaceArgument(0, $this->changeReference($requestDetector->getArgument(0), 'service_container'));

        if (!$container->hasDefinition('sonata.intl.locale_detector.session')) {
            return;
        }

        $sessionDetector = $container->getDefinition('sonata.intl.locale_detector.session');
        $sessionDetector->replaceArgument(0, $this->changeReference($sessionDetector->getArgument(0), 'session'));
    }

    /**
     * @param string $serviceId
     *
     * @return Reference
     */
    private function changeReference(Reference $reference, $serviceId)
    {
        return new Reference($serviceId, $reference->getInvalidBehavior());
    }
}
