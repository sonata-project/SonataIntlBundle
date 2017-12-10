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

namespace Sonata\IntlBundle\Tests\Locale;

use PHPUnit\Framework\TestCase;
use Sonata\IntlBundle\Locale\RequestStackDetector;

/**
 * Tests for the RequestStackDetector.
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class RequestStackDetectorTest extends TestCase
{
    protected function setUp(): void
    {
        if (!class_exists('Symfony\Component\HttpFoundation\RequestStack')) {
            $this->markTestSkipped('Only work with Symfony > 2.4');
        }
    }

    public function testGetLocale(): void
    {
        $requestStack = $this->createMock('Symfony\Component\HttpFoundation\RequestStack');
        $request = $this->createMock('Symfony\Component\HttpFoundation\Request');

        $requestStack
            ->expects($this->any())
            ->method('getCurrentRequest')
            ->will($this->returnValue($request))
        ;

        $request
            ->expects($this->any())
            ->method('getLocale')
            ->will($this->returnValue('en'))
        ;

        $detector = new RequestStackDetector($requestStack, 'America/Denver');
        $this->assertEquals('en', $detector->getLocale());
    }
}
