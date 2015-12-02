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
use Symfony\Component\HttpKernel\Kernel;

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
     *
     * @group legacy
     */
    public function testDetectsTimezoneForUser($timezone)
    {
        if (!class_exists('Sonata\UserBundle\Model\User')) {
            $this->markTestSkipped('SonataUserBundle not installed.');
        }

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

        if (Kernel::MAJOR_VERSION < 3) {
            $storage = $this->getMock('Symfony\Component\Security\Core\SecurityContextInterface');
            $storage
                ->expects($this->any())
                ->method('getToken')
                ->will($this->returnValue($token))
            ;
        } else {
            $storage = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface');
            $storage
                ->expects($this->any())
                ->method('getToken')
                ->will($this->returnValue($token))
            ;
        }

        $timezoneDetector = new UserBasedTimezoneDetector($storage);
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
