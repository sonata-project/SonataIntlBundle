<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Sonata\IntlBundle\Tests\Timezone;

use Sonata\IntlBundle\Timezone\LocaleBasedTimezoneDetector;

/**
 * Tests for the LocaleBasedTimezoneDetector.
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
class LocaleBasedTimezoneDetectorTest extends \PHPUnit_Framework_TestCase
{
    public function testDetectsTimezoneForLocale()
    {
        $localeDetector = $this->getMock('Sonata\IntlBundle\Locale\LocaleDetectorInterface');
        $localeDetector
            ->expects($this->any())
            ->method('getLocale')
            ->will($this->returnValue('fr'))
        ;

        $timezoneDetector = new LocaleBasedTimezoneDetector($localeDetector, array('fr' => 'Europe/Paris'));
        $this->assertEquals('Europe/Paris', $timezoneDetector->getTimezone());
    }

    public function testTimezoneNotDetected()
    {
        $localeDetector = $this->getMock('Sonata\IntlBundle\Locale\LocaleDetectorInterface');
        $localeDetector
            ->expects($this->any())
            ->method('getLocale')
            ->will($this->returnValue('de'))
        ;

        $timezoneDetector = new LocaleBasedTimezoneDetector($localeDetector, array('fr' => 'Europe/Paris'));
        $this->assertEquals(null, $timezoneDetector->getTimezone());
    }
}
