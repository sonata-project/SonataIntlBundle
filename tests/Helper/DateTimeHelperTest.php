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

namespace Sonata\IntlBundle\Tests\Helper;

use PHPUnit\Framework\TestCase;
use Sonata\IntlBundle\Locale\LocaleDetectorInterface;
use Sonata\IntlBundle\Templating\Helper\DateTimeHelper;
use Sonata\IntlBundle\Timezone\TimezoneDetectorInterface;

/**
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 * @author Alexander <iam.asm89@gmail.com>
 */
class DateTimeHelperTest extends TestCase
{
    protected function setUp(): void
    {
        date_default_timezone_set('Europe/Paris');
    }

    public function testLocale()
    {
        $localeDetector = $this->createMock(LocaleDetectorInterface::class);
        $localeDetector
            ->method('getLocale')->willReturn('en');

        $timezoneDetector = $this->createMock(TimezoneDetectorInterface::class);
        $timezoneDetector
            ->method('getTimezone')->willReturn('Europe/Paris');

        $helper = new DateTimeHelper($timezoneDetector, 'UTF-8', $localeDetector);

        $datetimeLondon = new \DateTime();
        $datetimeLondon->setDate(1981, 11, 30);
        $datetimeLondon->setTime(2, 0, 0);
        $datetimeLondon->setTimezone(new \DateTimeZone('Europe/London'));

        $datetimeParis = $helper->getDatetime('1981-11-30 02:00');

        $this->assertSame('Mon, 30 Nov 1981 01:00:00 +0000', $datetimeLondon->format('r'));
        $this->assertSame('Mon, 30 Nov 1981 02:00:00 +0100', $datetimeParis->format('r'));

        // check convertor
        $this->assertSame('375930000', $helper->getDatetime($datetimeParis)->format('U'));
        $this->assertSame('375930000', $helper->getDatetime($datetimeLondon)->format('U'));

        // warning .. this use value php.ini's timezone configuration
        $this->assertSame('1293708203', $helper->getDatetime('2010-12-30 12:23:23')->format('U'));
        $this->assertSame('1293663600', $helper->getDatetime('2010-12-30')->format('U'));
        $this->assertSame('1293708180', $helper->getDatetime('2010-12-30 12:23')->format('U'));

        // check default method
        $this->assertSame('Nov 30, 1981', $helper->formatDate($datetimeParis));
        $this->assertSame('Dec 30, 2010', $helper->formatDate('2010-12-30 12:23:23'));

        $this->assertSame('2:00:00 AM', $helper->formatTime($datetimeParis));
        $this->assertSame('Nov 30, 1981, 2:00:00 AM', $helper->formatDateTime($datetimeParis));

        // custom format
        $this->assertSame('November 30, 1981', $helper->formatDate($datetimeParis, null, null, \IntlDateFormatter::LONG));

        $this->assertSame('2:00:00 AM GMT+1', $helper->formatTime($datetimeParis, null, null, \IntlDateFormatter::LONG), 'ICU Version: '.DateTimeHelper::getICUDataVersion());

        $this->assertSame('November 30, 1981 at 2:00 AM', $helper->formatDateTime($datetimeParis, null, null, \IntlDateFormatter::LONG, \IntlDateFormatter::SHORT));
        $this->assertSame('30 Nov 1981 AD', $helper->format($datetimeParis, 'dd MMM Y G'));
    }

    public function testLocaleTimezones()
    {
        $localeDetector = $this->createMock(LocaleDetectorInterface::class);
        $localeDetector
            ->method('getLocale')->willReturn('en');

        $timezoneDetector = $this->createMock(TimezoneDetectorInterface::class);
        $timezoneDetector
            ->method('getTimezone')->willReturn('Europe/London');

        $timezoneDetectorWithMapping = $this->createMock(TimezoneDetectorInterface::class);
        $timezoneDetectorWithMapping
            ->method('getTimezone')->willReturn('Europe/Paris');

        $this->assertSame('Europe/London', $timezoneDetector->getTimezone());
        $this->assertSame('Europe/Paris', $timezoneDetectorWithMapping->getTimezone());

        // One helper without a locale mapping (current default)
        $helper = new DateTimeHelper($timezoneDetector, 'UTF-8', $localeDetector);

        // Helper with a mapping for the detected locale
        $helperWithMapping = new DateTimeHelper($timezoneDetectorWithMapping, 'UTF-8', $localeDetector);

        $dateLondon = new \DateTime('13:37', new \DateTimeZone('Europe/London'));

        // Test if the time is correctly corrected for the 'detected' timezone
        $this->assertSame('13:37', $helper->format($dateLondon, 'HH:mm'), 'A date in the Europe/London timezone, should not be corrected when formatted with timezone Europe/London.');
        $this->assertSame('14:37', $helperWithMapping->format($dateLondon, 'HH:mm'), 'A date in the Europe/London timezone, should be corrected when formatted with timezone Europe/Paris.');

        // Test if the time is correctly correct if the timezone is given as function parameter
        $this->assertSame('15:37', $helper->format($dateLondon, 'HH:mm', 'en', 'Europe/Helsinki'), 'A date in the Europe/London timezone, should be corrected when formatted with timezone Europe/Helsinki.');
        $this->assertSame('15:37', $helperWithMapping->format($dateLondon, 'HH:mm', 'en', 'Europe/Helsinki'), 'A date in the Europe/London timezone, should be corrected when formatted with timezone Europe/Helsinki.');

        // Test if the time is correctly corrected for the 'detected' timezone
        $dateParis = new \DateTime('13:37', new \DateTimeZone('Europe/Paris'));
        $this->assertSame('12:37', $helper->format($dateParis, 'HH:mm'), 'A date in the Europe/Paris timezone, should be corrected when formatted with timezone Europe/London.');
        $this->assertSame('13:37', $helperWithMapping->format($dateParis, 'HH:mm'), 'A date in the Europe/Paris timezone, should be corrected when formatted with timezone Europe/Paris.');
    }

    public function testImmutable()
    {
        $localeDetector = $this->createMock(LocaleDetectorInterface::class);
        $localeDetector
            ->method('getLocale')->willReturn('en');

        $timezoneDetector = $this->createMock(TimezoneDetectorInterface::class);
        $timezoneDetector
            ->method('getTimezone')->willReturn('Europe/Paris');

        $helper = new DateTimeHelper($timezoneDetector, 'UTF-8', $localeDetector);

        $date = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s T', '2009-02-15 15:16:17 HKT');

        $this->assertSame('08:16', $helper->format($date, 'HH:mm'));
    }
}
