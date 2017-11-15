<?php

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
use Sonata\IntlBundle\Templating\Helper\LocaleHelper;

class LocaleHelperTest extends TestCase
{
    public function getHelper()
    {
        $localeDetector = $this->createMock('Sonata\IntlBundle\Locale\LocaleDetectorInterface');
        $localeDetector->expects($this->any())
            ->method('getLocale')->will($this->returnValue('fr'));

        $helper = new LocaleHelper('UTF-8', $localeDetector);

        return $helper;
    }

    /**
     * @group legacy
     */
    public function testLanguage()
    {
        $helper = $this->getHelper();
        $this->assertEquals('français', $helper->language('fr'));
        $this->assertEquals('français', $helper->language('fr_FR'));
        $this->assertEquals('anglais américain', $helper->language('en_US'));
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
