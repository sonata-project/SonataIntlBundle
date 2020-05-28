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
use Sonata\IntlBundle\Timezone\TimezoneAwareInterface;
use Sonata\IntlBundle\Timezone\TimezoneAwareTrait;
use Sonata\IntlBundle\Timezone\UserBasedTimezoneDetector;
use Sonata\UserBundle\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
final class UserBasedTimezoneDetectorTest extends TestCase
{
    public static function timezoneProvider(): iterable
    {
        return [
            ['Europe/Paris'],
            [null],
        ];
    }

    /**
     * @dataProvider timezoneProvider
     */
    public function testUserTimezoneDetection(?string $timezone): void
    {
        $user = new class($timezone) implements TimezoneAwareInterface {
            use TimezoneAwareTrait;

            public function __construct(?string $timezone)
            {
                $this->timezone = $timezone;
            }
        };

        $token = $this->createMock(TokenInterface::class);
        $token
            ->expects($this->once())
            ->method('getUser')
            ->willReturn($user)
        ;

        $storage = $this->createMock(TokenStorageInterface::class);

        $storage
            ->expects($this->once())
            ->method('getToken')
            ->willReturn($token)
        ;

        $timezoneDetector = new UserBasedTimezoneDetector($storage);
        $this->assertSame($timezone, $timezoneDetector->getTimezone());
    }

    /**
     * @dataProvider timezoneProvider
     *
     * @group legacy
     *
     * @expectedDeprecation Timezone inference based on the "Sonata\UserBundle\Model\User" class is deprecated since sonata-project/intl-bundle 2.x and will be dropped in 3.0 version. Implement "Sonata\IntlBundle\Timezone\TimezoneAwareInterface" explicitly in your user class instead.
     */
    public function testDetectsTimezoneForUser(?string $timezone): void
    {
        if (!class_exists(User::class)) {
            $this->markTestSkipped(sprintf(
                '"%s" class must be available to run this test. You should install sonata-project/user-bundle.',
                User::class
            ));
        }

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

    public function testTimezoneNotDetected(): void
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
