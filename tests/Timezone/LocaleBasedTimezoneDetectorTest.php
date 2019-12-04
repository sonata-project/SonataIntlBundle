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
use Sonata\IntlBundle\Locale\LocaleDetectorInterface;
use Sonata\IntlBundle\Timezone\LocaleBasedTimezoneDetector;

/**
 * @author Alexander <iam.asm89@gmail.com>
 */
class LocaleBasedTimezoneDetectorTest extends TestCase
{
    public function testDetectsTimezoneForLocale()
    {
        $localeDetector = $this->createMock(LocaleDetectorInterface::class);
        $localeDetector
            ->method('getLocale')
            ->willReturn('fr')
        ;

        $timezoneDetector = new LocaleBasedTimezoneDetector($localeDetector, ['fr' => 'Europe/Paris']);
        $this->assertSame('Europe/Paris', $timezoneDetector->getTimezone());
    }

    public function testTimezoneNotDetected()
    {
        $localeDetector = $this->createMock(LocaleDetectorInterface::class);
        $localeDetector
            ->method('getLocale')
            ->willReturn('de')
        ;

        $timezoneDetector = new LocaleBasedTimezoneDetector($localeDetector, ['fr' => 'Europe/Paris']);
        $this->assertNull($timezoneDetector->getTimezone());
    }
}
