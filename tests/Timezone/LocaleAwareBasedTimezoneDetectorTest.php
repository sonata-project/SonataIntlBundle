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
use Sonata\IntlBundle\Timezone\LocaleAwareBasedTimezoneDetector;

/**
 * @author Alexander <iam.asm89@gmail.com>
 */
final class LocaleAwareBasedTimezoneDetectorTest extends TestCase
{
    public function testDetectsTimezoneForLocale(): void
    {
        $timezoneDetector = new LocaleAwareBasedTimezoneDetector(['fr' => 'Europe/Paris']);
        $timezoneDetector->setLocale('fr');
        static::assertSame('Europe/Paris', $timezoneDetector->getTimezone());
    }

    public function testTimezoneNotDetected(): void
    {
        $timezoneDetector = new LocaleAwareBasedTimezoneDetector(['fr' => 'Europe/Paris']);
        $timezoneDetector->setLocale('de');
        static::assertNull($timezoneDetector->getTimezone());
    }
}
