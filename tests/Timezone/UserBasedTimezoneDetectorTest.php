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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
final class UserBasedTimezoneDetectorTest extends TestCase
{
    /**
     * @return iterable<array{string|null}>
     */
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
        $user = new class($timezone) implements UserInterface, TimezoneAwareInterface {
            use TimezoneAwareTrait;

            public function __construct(?string $timezone)
            {
                $this->timezone = $timezone;
            }

            public function getPassword(): ?string
            {
                return null;
            }

            public function getSalt(): ?string
            {
                return null;
            }

            public function getUsername(): string
            {
                return $this->getUserIdentifier();
            }

            public function getRoles(): array
            {
                return [];
            }

            public function eraseCredentials(): void
            {
            }

            public function getUserIdentifier(): string
            {
                return 'john';
            }
        };

        $token = $this->createMock(TokenInterface::class);
        $token
            ->expects(static::once())
            ->method('getUser')
            ->willReturn($user);

        $storage = $this->createMock(TokenStorageInterface::class);

        $storage
            ->expects(static::once())
            ->method('getToken')
            ->willReturn($token);

        $timezoneDetector = new UserBasedTimezoneDetector($storage);
        static::assertSame($timezone, $timezoneDetector->getTimezone());
    }

    public function testTimezoneNotDetected(): void
    {
        $storage = $this->createMock(TokenStorageInterface::class);

        $storage
            ->method('getToken')
            ->willReturn(null);

        $timezoneDetector = new UserBasedTimezoneDetector($storage);
        static::assertNull($timezoneDetector->getTimezone());
    }
}
