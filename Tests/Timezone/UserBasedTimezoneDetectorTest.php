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

use Sonata\IntlBundle\Timezone\UserBasedTimezoneDetector;

/**
 * Tests for the LocaleBasedTimezoneDetector.
 *
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
class UserBasedTimezoneDetectorTest extends \PHPUnit_Framework_TestCase
{
    public static function timezoneProvider()
    {
        return array(
            array('Europe/Paris'),
            array(null),
        );
    }

    /**
     * @dataProvider timezoneProvider
     */
    public function testDetectsTimezoneForUser($timezone)
    {
        $user = $this->getMock('Sonata\UserBundle\Model\User');
        $user
            ->expects($this->any())
            ->method('getTimezone')
            ->will($this->returnValue($timezone))
        ;

        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $token
            ->expects($this->any())
            ->method('getUser')
            ->will($this->returnValue($user))
        ;

        $securityContext = $this->getMock('Symfony\Component\Security\Core\SecurityContextInterface');
        $securityContext
            ->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue($token))
        ;

        $timezoneDetector = new UserBasedTimezoneDetector($securityContext);
        $this->assertEquals($timezone, $timezoneDetector->getTimezone());
    }

    public function testTimezoneNotDetected()
    {
        $securityContext = $this->getMock('Symfony\Component\Security\Core\SecurityContextInterface');
        $securityContext
            ->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue(null))
        ;

        $timezoneDetector = new UserBasedTimezoneDetector($securityContext);
        $this->assertEquals(null, $timezoneDetector->getTimezone());
    }
}
