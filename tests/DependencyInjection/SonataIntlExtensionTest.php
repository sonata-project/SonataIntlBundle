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

namespace Sonata\IntlBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Sonata\IntlBundle\DependencyInjection\SonataIntlExtension;

class SonataIntlExtensionTest extends AbstractExtensionTestCase
{
    public function testLoad(): void
    {
        $this->setParameter('kernel.bundles', []);
        $this->setParameter('kernel.default_locale', 'en');
        $this->load();

        if (class_exists('Symfony\Component\HttpFoundation\RequestStack')) {
            $this->assertContainerBuilderHasAlias('sonata.intl.locale_detector', 'sonata.intl.locale_detector.request_stack');
        } elseif (method_exists('Symfony\Component\HttpFoundation\Request', 'getLocale')) {
            $this->assertContainerBuilderHasAlias('sonata.intl.locale_detector', 'sonata.intl.locale_detector.request');
        } else {
            $this->assertContainerBuilderHasAlias('sonata.intl.locale_detector', 'sonata.intl.locale_detector.session');
        }
    }

    protected function getContainerExtensions()
    {
        return [
            new SonataIntlExtension(),
        ];
    }
}
