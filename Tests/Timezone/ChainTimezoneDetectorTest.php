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

use Sonata\IntlBundle\Timezone\ChainTimezoneDetector;

/**
 * Tests for the LocaleBasedTimezoneDetector.
 *
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
class ChainTimezoneDetectorTest extends \PHPUnit_Framework_TestCase
{
    public static function timezoneProvider()
    {
        return array(
            array(array('Europe/Paris', 'Europe/London'), 'Europe/Paris'),
            array(array('Europe/Paris', null), 'Europe/Paris'),
            array(array(null, 'Europe/Paris'), 'Europe/Paris'),
            array(array(null, null), 'America/Denver'),
            array(array('Invalid/Timezone', null), 'America/Denver'),
        );
    }

    /**
     * @dataProvider timezoneProvider
     */
    public function testDetectsTimezoneForUser($detectorsTimezones, $expectedTimezone)
    {
        $chainTimezoneDetector = new ChainTimezoneDetector('America/Denver');

        foreach ($detectorsTimezones as $timezone) {
            $timezoneDetector = $this->getMock('Sonata\IntlBundle\Timezone\TimezoneDetectorInterface');
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
