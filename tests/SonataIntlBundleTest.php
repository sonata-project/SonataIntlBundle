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

namespace Sonata\IntlBundle\Tests\Helper;

use PHPUnit\Framework\TestCase;
use Sonata\IntlBundle\SonataIntlBundle;

class SonataIntlBundleTest extends TestCase
{
    /**
     * @return iterable<array{string, string, bool, bool}>
     */
    public function provideSymfonyVersionCases(): iterable
    {
        yield ['2.0.1', '2.0.1', true, true];
        yield ['2.0.2', '2.0.1', true, true];
        yield ['2.1.1-DEV', '2.1.1', false, true];
        yield ['2.1.0-RC1', '2.1.0', false, true];
        yield ['2.1.0-RC1', '2.1.1', false, false];
    }

    /**
     * @dataProvider provideSymfonyVersionCases
     */
    public function testSymfonyVersion(string $currentVersion, string $minVersion, bool $versionExpected, bool $versionBundle): void
    {
        static::assertSame(
            $versionExpected,
            version_compare($currentVersion, $minVersion, '>=')
        );

        static::assertSame(
            $versionBundle,
            version_compare(SonataIntlBundle::getSymfonyVersion($currentVersion), $minVersion, '>=')
        );
    }
}
