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

namespace Sonata\IntlBundle\Tests\Timezone;

use PHPUnit\Framework\TestCase;
use Sonata\IntlBundle\Timezone\ChainTimezoneDetector;
use Sonata\IntlBundle\Timezone\TimezoneDetectorInterface;

/**
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
final class ChainTimezoneDetectorTest extends TestCase
{
    /**
     * @return iterable<array{array<string|null>, string}>
     */
    public static function provideDetectsTimezoneForUserCases(): iterable
    {
        yield [['Europe/Paris', 'Europe/London'], 'Europe/Paris'];
        yield [['Europe/Paris', null], 'Europe/Paris'];
        yield [[null, 'Europe/Paris'], 'Europe/Paris'];
        yield [[null, null], 'America/Denver'];
        yield [['Invalid/Timezone', null], 'America/Denver'];
    }

    /**
     * @param array<string|null> $detectorsTimezones
     *
     * @dataProvider provideDetectsTimezoneForUserCases
     */
    public function testDetectsTimezoneForUser(array $detectorsTimezones, string $expectedTimezone): void
    {
        $chainTimezoneDetector = new ChainTimezoneDetector('America/Denver');

        foreach ($detectorsTimezones as $timezone) {
            $timezoneDetector = $this->createMock(TimezoneDetectorInterface::class);
            $timezoneDetector
                ->method('getTimezone')
                ->willReturn($timezone);

            $chainTimezoneDetector->addDetector($timezoneDetector);
        }

        static::assertSame($expectedTimezone, $chainTimezoneDetector->getTimezone());
    }
}
