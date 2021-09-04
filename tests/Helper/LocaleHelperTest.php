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
        $localeDetector
            ->method('getLocale')->willReturn('fr');

        return new LocaleHelper('UTF-8', $localeDetector);
    }

    /**
     * @group legacy
     */
    public function testLanguage(): void
    {
        $helper = $this->getHelper();
        static::assertSame('français', $helper->language('fr'));
        static::assertSame('français', $helper->language('fr_FR'));
        static::assertSame('anglais américain', $helper->language('en_US'));
        static::assertSame('French', $helper->language('fr', 'en'));
    }

    public function testCountry(): void
    {
        $helper = $this->getHelper();
        static::assertSame('France', $helper->country('FR'));
        static::assertSame('France', $helper->country('FR', 'en'));
        //        $this->assertEquals('', $helper->country('FR', 'fake'));
    }

    public function testLocale(): void
    {
        $helper = $this->getHelper();

        static::assertSame('français', $helper->locale('fr'));
        static::assertSame('français (Canada)', $helper->locale('fr_CA'));

        static::assertSame('French', $helper->locale('fr', 'en'));
        static::assertSame('French (Canada)', $helper->locale('fr_CA', 'en'));
        //        $this->assertEquals('', $helper->locale('fr', 'fake'));
        //        $this->assertEquals('', $helper->locale('fr_CA', 'fake'));
    }
}
