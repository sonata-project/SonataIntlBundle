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
use Sonata\IntlBundle\Timezone\LocaleBasedTimezoneDetector;

/**
 * Tests for the LocaleBasedTimezoneDetector.
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
class LocaleBasedTimezoneDetectorTest extends TestCase
{
    public function testDetectsTimezoneForLocale(): void
    {
        $localeDetector = $this->createMock('Sonata\IntlBundle\Locale\LocaleDetectorInterface');
        $localeDetector
            ->expects($this->any())
            ->method('getLocale')
            ->will($this->returnValue('fr'))
        ;

        $timezoneDetector = new LocaleBasedTimezoneDetector($localeDetector, ['fr' => 'Europe/Paris']);
        $this->assertEquals('Europe/Paris', $timezoneDetector->getTimezone());
    }

    public function testTimezoneNotDetected(): void
    {
        $localeDetector = $this->createMock('Sonata\IntlBundle\Locale\LocaleDetectorInterface');
        $localeDetector
            ->expects($this->any())
            ->method('getLocale')
            ->will($this->returnValue('de'))
        ;

        $timezoneDetector = new LocaleBasedTimezoneDetector($localeDetector, ['fr' => 'Europe/Paris']);
        $this->assertNull($timezoneDetector->getTimezone());
    }
}
