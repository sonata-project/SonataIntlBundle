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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class RequestStackDetectorTest extends TestCase
{
    public function testGetLocale()
    {
        $requestStack = $this->createMock(RequestStack::class);
        $request = $this->createMock(Request::class);

        $requestStack
            ->method('getCurrentRequest')
            ->willReturn($request);

        $request
            ->method('getLocale')
            ->willReturn('en');

        $detector = new RequestStackDetector($requestStack, 'America/Denver');
        $this->assertSame('en', $detector->getLocale());
    }
}
