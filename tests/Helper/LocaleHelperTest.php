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
use Sonata\IntlBundle\Templating\Helper\LocaleHelper;

class LocaleHelperTest extends TestCase
{
    public function getHelper()
    {
        $localeDetector = $this->createMock(LocaleDetectorInterface::class);
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
        $this->assertSame('français', $helper->language('fr'));
        $this->assertSame('français', $helper->language('fr_FR'));
        $this->assertSame('anglais américain', $helper->language('en_US'));
        $this->assertSame('French', $helper->language('fr', 'en'));
        //        $this->assertEquals('', $helper->language('fr', 'fake'));
    }

    public function testCountry()
    {
        $helper = $this->getHelper();
        $this->assertSame('France', $helper->country('FR'));
        $this->assertSame('France', $helper->country('FR', 'en'));
        //        $this->assertEquals('', $helper->country('FR', 'fake'));
    }

    public function testLocale()
    {
        $helper = $this->getHelper();

        $this->assertSame('français', $helper->locale('fr'));
        $this->assertSame('français (Canada)', $helper->locale('fr_CA'));

        $this->assertSame('French', $helper->locale('fr', 'en'));
        $this->assertSame('French (Canada)', $helper->locale('fr_CA', 'en'));
        //        $this->assertEquals('', $helper->locale('fr', 'fake'));
        //        $this->assertEquals('', $helper->locale('fr_CA', 'fake'));
    }
}
