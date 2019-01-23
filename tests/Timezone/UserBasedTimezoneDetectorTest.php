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
use Sonata\IntlBundle\Timezone\UserBasedTimezoneDetector;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
class UserBasedTimezoneDetectorTest extends TestCase
{
    protected function setUp()
    {
        if (!class_exists('Sonata\UserBundle\SonataUserBundle')) {
            $this->markTestSkipped('SonataUserBundle must be installed to run this test.');
        }
    }

    public static function timezoneProvider()
    {
        return [
            ['Europe/Paris'],
            [null],
        ];
    }

    /**
     * @dataProvider timezoneProvider
     *
     * @group legacy
     */
    public function testDetectsTimezoneForUser($timezone)
    {
        $user = $this->createMock('Sonata\UserBundle\Model\User');
        $user
            ->expects($this->any())
            ->method('getTimezone')
            ->will($this->returnValue($timezone))
        ;

        $token = $this->createMock(TokenInterface::class);
        $token
            ->expects($this->any())
            ->method('getUser')
            ->will($this->returnValue($user))
        ;

        if (interface_exists('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface')) {
            $storage = $this->createMock('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface');
        } else {
            $storage = $this->createMock('Symfony\Component\Security\Core\SecurityContextInterface');
        }

        $storage
            ->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue($token))
        ;

        $timezoneDetector = new UserBasedTimezoneDetector($storage);
        $this->assertSame($timezone, $timezoneDetector->getTimezone());
    }

    public function testTimezoneNotDetected()
    {
        if (interface_exists('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface')) {
            $storage = $this->createMock('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface');
        } else {
            $storage = $this->createMock('Symfony\Component\Security\Core\SecurityContextInterface');
        }

        $storage
            ->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue(null))
        ;

        $timezoneDetector = new UserBasedTimezoneDetector($storage);
        $this->assertNull($timezoneDetector->getTimezone());
    }

    public function testInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument 1 should be an instance of Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface or Symfony\Component\Security\Core\SecurityContextInterface');

        new UserBasedTimezoneDetector(new \stdClass());
    }
}
