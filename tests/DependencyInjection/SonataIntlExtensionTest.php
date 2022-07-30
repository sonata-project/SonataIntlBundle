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
use Sonata\IntlBundle\Helper\DateTimeFormatterInterface;

final class SonataIntlExtensionTest extends AbstractExtensionTestCase
{
    public function testLoad(): void
    {
        $this->setParameter('kernel.bundles', []);
        $this->setParameter('kernel.default_locale', 'en');
        $this->load();

        $this->assertContainerBuilderHasAlias(DateTimeFormatterInterface::class, 'sonata.intl.helper.datetime');
    }

    protected function getContainerExtensions(): array
    {
        return [
            new SonataIntlExtension(),
        ];
    }
}
