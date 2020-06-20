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
     * @var LocaleDetectorInterface
     */
    private $localeDetector;

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
        // NEXT_MAJOR: Remove the following assignment.
        $this->localeDetector = $localeDetector;
    }

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
            'Not passing an instance of "%s" as argument 3 for "%s::__construct()" is deprecated since sonata-project/intl-bundle 2.x'
            .' and will throw an exception in version 3.x.',
            IntlExtension::class,
            LocaleHelper::class
        ));

        $localeHelper = $this->createLegacyLocaleHelper();

        $this->assertSame('français', $localeHelper->language('fr'));
        $this->assertSame('français', $localeHelper->language('fr_FR'));
        $this->assertSame('anglais américain', $localeHelper->language('en_US'));
        $this->assertSame('French', $localeHelper->language('fr', 'en'));
    }

    /**
     * NEXT_MAJOR: Remove this method.
     *
     * @group legacy
     */
    public function testLegacyCountry(): void
    {
        $this->expectDeprecation(sprintf(
            'Not passing an instance of "%s" as argument 3 for "%s::__construct()" is deprecated since sonata-project/intl-bundle 2.x'
            .' and will throw an exception in version 3.x.',
            IntlExtension::class,
            LocaleHelper::class
        ));

        $localeHelper = $this->createLegacyLocaleHelper();

        $this->assertSame('France', $localeHelper->country('FR'));
        $this->assertSame('France', $localeHelper->country('FR', 'en'));
    }

    /**
     * NEXT_MAJOR: Remove this method.
     *
     * @group legacy
     */
    public function testLegacyLocale(): void
    {
        $this->expectDeprecation(sprintf(
            'Not passing an instance of "%s" as argument 3 for "%s::__construct()" is deprecated since sonata-project/intl-bundle 2.x'
            .' and will throw an exception in version 3.x.',
            IntlExtension::class,
            LocaleHelper::class
        ));

        $localeHelper = $this->createLegacyLocaleHelper();

        $this->assertSame('français', $localeHelper->locale('fr'));
        $this->assertSame('français (Canada)', $localeHelper->locale('fr_CA'));

        $this->assertSame('French', $localeHelper->locale('fr', 'en'));
        $this->assertSame('French (Canada)', $localeHelper->locale('fr_CA', 'en'));
    }

    /**
     * NEXT_MAJOR: Remove this method.
     */
    private function createLegacyLocaleHelper(): LocaleHelper
    {
        return new LocaleHelper('UTF-8', $this->localeDetector);
    }
}
