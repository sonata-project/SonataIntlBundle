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
use Sonata\UserBundle\Model\User;
use Sonata\UserBundle\SonataUserBundle;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
class UserBasedTimezoneDetectorTest extends TestCase
{
    protected function setUp(): void
    {
        if (!class_exists(SonataUserBundle::class)) {
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
        $user = $this->createMock(User::class);
        $user
            ->method('getTimezone')
            ->willReturn($timezone)
        ;

        $token = $this->createMock(TokenInterface::class);
        $token
            ->method('getUser')
            ->willReturn($user)
        ;

        $storage = $this->createMock(TokenStorageInterface::class);

        $storage
            ->method('getToken')
            ->willReturn($token)
        ;

        $timezoneDetector = new UserBasedTimezoneDetector($storage);
        $this->assertSame($timezone, $timezoneDetector->getTimezone());
    }

    public function testTimezoneNotDetected()
    {
        $storage = $this->createMock(TokenStorageInterface::class);

        $storage
            ->method('getToken')
            ->willReturn(null)
        ;

        $timezoneDetector = new UserBasedTimezoneDetector($storage);
        $this->assertNull($timezoneDetector->getTimezone());
    }
}
