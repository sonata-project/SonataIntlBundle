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
use Symfony\Bridge\PhpUnit\ExpectDeprecationTrait;
use Symfony\Component\Templating\Helper\HelperInterface;
use Twig\Extra\Intl\IntlExtension;

final class LocaleHelperTest extends TestCase
{
    use ExpectDeprecationTrait;

    /**
     * NEXT_MAJOR: Remove this property.
     *
     * @var HelperInterface
     */
    private $legacyLocaleHelper;

    /**
     * @var HelperInterface
     */
    private $localeHelper;

    protected function setUp(): void
    {
        $localeDetector = $this->createMock(LocaleDetectorInterface::class);
        $localeDetector
            ->method('getLocale')->willReturn('fr');

        $this->localeHelper = new LocaleHelper('UTF-8', $localeDetector, new IntlExtension());
        $this->legacyLocaleHelper = new LocaleHelper('UTF-8', $localeDetector);
    }

    /**
     * @group legacy
     */
    public function testLanguage(): void
    {
        $this->assertSame('français', $this->localeHelper->language('fr'));
        $this->assertSame('français', $this->localeHelper->language('fr_FR'));
        $this->assertSame('anglais américain', $this->localeHelper->language('en_US'));
        $this->assertSame('French', $this->localeHelper->language('fr', 'en'));
    }

    public function testCountry(): void
    {
        $this->assertSame('France', $this->localeHelper->country('FR'));
        $this->assertSame('France', $this->localeHelper->country('FR', 'en'));
        //        $this->assertEquals('', $this->localeHelper->country('FR', 'fake'));
    }

    public function testLocale(): void
    {
        $this->assertSame('français', $this->localeHelper->locale('fr'));
        $this->assertSame('français (Canada)', $this->localeHelper->locale('fr_CA'));

        $this->assertSame('French', $this->localeHelper->locale('fr', 'en'));
        $this->assertSame('French (Canada)', $this->localeHelper->locale('fr_CA', 'en'));
        //        $this->assertEquals('', $this->localeHelper->locale('fr', 'fake'));
        //        $this->assertEquals('', $this->localeHelper->locale('fr_CA', 'fake'));
    }

    /**
     * NEXT_MAJOR: Remove this method.
     *
     * @group legacy
     */
    public function testLegacyLanguage(): void
    {
        $this->expectDeprecation(sprintf(
            'Not passing an instance of "%s" as argument 3 for "%s::__construct()" is deprecated since sonata-project/intl-bundle 2.x.'
            .' and will throw an exception since version 3.x.',
            IntlExtension::class,
            LocaleHelper::class
        ));

        $this->assertSame('français', $this->legacyLocaleHelper->language('fr'));
        $this->assertSame('français', $this->legacyLocaleHelper->language('fr_FR'));
        $this->assertSame('anglais américain', $this->legacyLocaleHelper->language('en_US'));
        $this->assertSame('French', $this->legacyLocaleHelper->language('fr', 'en'));
    }

    /**
     * NEXT_MAJOR: Remove this method.
     *
     * @group legacy
     */
    public function testLegacyCountry(): void
    {
        $this->assertSame('France', $this->legacyLocaleHelper->country('FR'));
        $this->assertSame('France', $this->legacyLocaleHelper->country('FR', 'en'));
    }

    /**
     * NEXT_MAJOR: Remove this method.
     *
     * @group legacy
     */
    public function testLegacyLocale(): void
    {
        $this->assertSame('français', $this->legacyLocaleHelper->locale('fr'));
        $this->assertSame('français (Canada)', $this->legacyLocaleHelper->locale('fr_CA'));

        $this->assertSame('French', $this->legacyLocaleHelper->locale('fr', 'en'));
        $this->assertSame('French (Canada)', $this->legacyLocaleHelper->locale('fr_CA', 'en'));
    }
}
