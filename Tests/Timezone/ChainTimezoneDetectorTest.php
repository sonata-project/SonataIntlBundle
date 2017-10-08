<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\IntlBundle\Tests\Timezone;

use Sonata\IntlBundle\Tests\Helpers\PHPUnit_Framework_TestCase;
use Sonata\IntlBundle\Timezone\ChainTimezoneDetector;

/**
 * Tests for the LocaleBasedTimezoneDetector.
 *
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
class ChainTimezoneDetectorTest extends PHPUnit_Framework_TestCase
{
    public static function timezoneProvider()
    {
        return [
            [['Europe/Paris', 'Europe/London'], 'Europe/Paris'],
            [['Europe/Paris', null], 'Europe/Paris'],
            [[null, 'Europe/Paris'], 'Europe/Paris'],
            [[null, null], 'America/Denver'],
            [['Invalid/Timezone', null], 'America/Denver'],
        ];
    }

    /**
     * @dataProvider timezoneProvider
     */
    public function testDetectsTimezoneForUser($detectorsTimezones, $expectedTimezone)
    {
        $chainTimezoneDetector = new ChainTimezoneDetector('America/Denver');

        foreach ($detectorsTimezones as $timezone) {
            $timezoneDetector = $this->createMock('Sonata\IntlBundle\Timezone\TimezoneDetectorInterface');
            $timezoneDetector
                ->expects($this->any())
                ->method('getTimezone')
                ->will($this->returnValue($timezone))
            ;

            $chainTimezoneDetector->addDetector($timezoneDetector);
        }

        $this->assertEquals($expectedTimezone, $chainTimezoneDetector->getTimezone());
    }
}
