<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\IntlBundle\Tests;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Sonata\IntlBundle\DependencyInjection\SonataIntlExtension;

class SonataIntlExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions()
    {
        return array(
            new SonataIntlExtension(),
        );
    }

    public function testLoad()
    {
        $this->setParameter('kernel.bundles', array());
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
}
