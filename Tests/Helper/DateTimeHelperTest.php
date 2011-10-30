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

namespace Sonata\IntlBundle\Tests\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Sonata\IntlBundle\Templating\Helper\DateTimeHelper;

class DateTimeHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testLocale()
    {
        $localeDetector = $this->getMock('Sonata\IntlBundle\Locale\LocaleDetectorInterface');
        $localeDetector->expects($this->any())
            ->method('getLocale')->will($this->returnValue('fr'));

        $helper = new DateTimeHelper(new \DateTimeZone('Europe/Paris'), 'UTF-8', $localeDetector);

        $datetimeLondon = new \DateTime();
        $datetimeLondon->setDate(1981, 11, 30);
        $datetimeLondon->setTime(2, 0, 0);
        $datetimeLondon->setTimezone(new \DateTimeZone('Europe/London'));

        $datetimeParis = $helper->getDatetime('1981-11-30 02:00');

        $this->assertEquals('Mon, 30 Nov 1981 01:00:00 +0000', $datetimeLondon->format('r'));
        $this->assertEquals('Mon, 30 Nov 1981 02:00:00 +0100', $datetimeParis->format('r'));

        // check convertor
        $this->assertEquals(375930000, $helper->getDatetime($datetimeParis)->format('U'));
        $this->assertEquals(375930000, $helper->getDatetime($datetimeLondon)->format('U'));

        // warning .. this use value php.ini's timezone configuration
        $this->assertEquals(1293708203, $helper->getDatetime('2010-12-30 12:23:23')->format('U'));
        $this->assertEquals(1293663600, $helper->getDatetime('2010-12-30')->format('U'));
        $this->assertEquals(1293708180, $helper->getDatetime('2010-12-30 12:23')->format('U'));


        // check default method
        $this->assertEquals('30 nov. 1981', $helper->formatDate($datetimeParis));
        $this->assertEquals('30 déc. 2010', $helper->formatDate('2010-12-30 12:23:23'));

        $this->assertEquals('02:00:00', $helper->formatTime($datetimeParis));
        $this->assertEquals('30 nov. 1981 02:00:00', $helper->formatDateTime($datetimeParis));

        // custom format
        $this->assertEquals('30 nov. 1981 ap. J.-C.', $helper->format($datetimeParis, 'dd MMM Y G'));
    }
}