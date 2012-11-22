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

use Sonata\IntlBundle\Templating\Helper\LocaleHelper;
use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Locale\Locale;

class LocaleHelperTest extends \PHPUnit_Framework_TestCase
{
    public function getHelper()
    {
        $localeDetector = $this->getMock('Sonata\IntlBundle\Locale\LocaleDetectorInterface');
        $localeDetector->expects($this->any())
            ->method('getLocale')->will($this->returnValue('fr'));

        $helper = new LocaleHelper('UTF-8', $localeDetector);

        return $helper;
    }

    public function testLanguage()
    {
        $helper = $this->getHelper();
        $this->assertEquals('français', $helper->language('fr'));
        $this->assertEquals('French', $helper->language('fr', 'en'));
        //        $this->assertEquals('', $helper->language('fr', 'fake'));

    }

    public function testCountry()
    {
        $helper = $this->getHelper();
        $this->assertEquals('France', $helper->country('FR'));
        $this->assertEquals('France', $helper->country('FR', 'en'));
//        $this->assertEquals('', $helper->country('FR', 'fake'));
    }

    public function testLocale()
    {
        $helper = $this->getHelper();

        $this->assertEquals('français', $helper->locale('fr'));
        $this->assertEquals('français (Canada)', $helper->locale('fr_CA'));

        $this->assertEquals('French', $helper->locale('fr', 'en'));
        $this->assertEquals('French (Canada)', $helper->locale('fr_CA', 'en'));
        //        $this->assertEquals('', $helper->locale('fr', 'fake'));
        //        $this->assertEquals('', $helper->locale('fr_CA', 'fake'));

    }
}
