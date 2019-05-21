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
use Sonata\IntlBundle\Templating\Helper\NumberHelper;

/**
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
class NumberHelperTest extends TestCase
{
    public function testLocale(): void
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);

        // currency
        $this->assertSame('€10.49', $helper->formatCurrency(10.49, 'EUR'));
        $this->assertSame('€10.50', $helper->formatCurrency(10.499, 'EUR'));
        $this->assertSame('€10,000.50', $helper->formatCurrency(10000.499, 'EUR'));

        // test compatibility with Doctrine's decimal type (fixed-point number represented as string)
        $this->assertSame('€10.49', $helper->formatCurrency('10.49', 'EUR'));

        $this->assertSame('€10.49', $helper->formatCurrency(10.49, 'EUR', [
            // the fraction_digits is not supported by the currency lib, https://bugs.php.net/bug.php?id=63140
            'fraction_digits' => 0,
        ]));

        // decimal
        $this->assertSame('10', $helper->formatDecimal(10));
        $this->assertSame('10.155', $helper->formatDecimal(10.15459));
        $this->assertSame('1,000,000.155', $helper->formatDecimal(1000000.15459));

        // scientific
        $this->assertSame('1E1', $helper->formatScientific(10));
        $this->assertSame('1E3', $helper->formatScientific(1000));
        $this->assertSame('1.0001E3', $helper->formatScientific(1000.1));
        $this->assertSame('1.00000015459E6', $helper->formatScientific(1000000.15459));
        $this->assertSame('1.00000015459E6', $helper->formatScientific(1000000.15459));

        // duration
        $this->assertSame('277:46:40', $helper->formatDuration(1000000));

        // spell out
        $this->assertSame('one', $helper->formatSpellout(1));
        $this->assertSame('forty-two', $helper->formatSpellout(42));

        $this->assertSame('one million two hundred twenty-four thousand five hundred fifty-seven point one two five four', $helper->formatSpellout(1224557.1254));

        // percent
        $this->assertSame('10%', $helper->formatPercent(0.1));
        $this->assertSame('200%', $helper->formatPercent(1.999));
        $this->assertSame('99%', $helper->formatPercent(0.99));

        // ordinal
        $this->assertSame('1st', $helper->formatOrdinal(1), 'ICU Version: '.NumberHelper::getICUDataVersion());
        $this->assertSame('100th', $helper->formatOrdinal(100), 'ICU Version: '.NumberHelper::getICUDataVersion());
        $this->assertSame('10,000th', $helper->formatOrdinal(10000), 'ICU Version: '.NumberHelper::getICUDataVersion());
    }

    public function testArguments(): void
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector, ['fraction_digits' => 2], ['negative_prefix' => 'MINUS']);

        // Check that the 'default' options are used
        $this->assertSame('1.34', $helper->formatDecimal(1.337));
        $this->assertSame('MINUS1.34', $helper->formatDecimal(-1.337));

        // Check that the options are overwritten
        $this->assertSame('1.337', $helper->formatDecimal(1.337, ['fraction_digits' => 3]));
        $this->assertSame('MIN1.34', $helper->formatDecimal(-1.337, [], ['negative_prefix' => 'MIN']));
    }

    public function testExceptionOnInvalidParams(): void
    {
        $this->expectException(\RuntimeException::class);

        // https://wiki.php.net/rfc/internal_constructor_behaviour
        try {
            $formatter = new \NumberFormatter('EN', -1);
        } catch (\IntlException $e) {
            throw new \RuntimeException($e->getMessage());
        }

        $this->assertNull($formatter);

        $localeDetector = $this->createMock(LocaleDetectorInterface::class);
        $localeDetector->expects($this->any())
            ->method('getLocale')->willReturn('en');

        $helper = new NumberHelper('UTF-8', $localeDetector, ['fraction_digits' => 2], ['negative_prefix' => 'MINUS']);

        $helper->format(10.49, -1);
    }

    /**
     * @dataProvider provideConstantValues
     */
    public function testParseConstantValue($constantName, $expectedConstant, $exceptionExpected): void
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);
        $method = new \ReflectionMethod($helper, 'parseConstantValue');
        $method->setAccessible(true);

        if ($exceptionExpected) {
            $this->expectException(\InvalidArgumentException::class);
        }

        $this->assertSame($expectedConstant, $method->invoke($helper, $constantName));
    }

    public function provideConstantValues()
    {
        return [
            ['positive_prefix', \NumberFormatter::POSITIVE_PREFIX, false],
            ['non_existent_constant', \NumberFormatter::NEGATIVE_PREFIX, true],
        ];
    }

    /**
     * @dataProvider provideAttributeValues
     */
    public function testParseAttributes($attributes, $expectedAttributes, $exceptionExpected): void
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);
        $method = new \ReflectionMethod($helper, 'parseAttributes');
        $method->setAccessible(true);

        if ($exceptionExpected) {
            $this->expectException(\InvalidArgumentException::class);
        }

        $this->assertSame($expectedAttributes, $method->invoke($helper, $attributes));
    }

    public function provideAttributeValues()
    {
        return [
            [
                [
                    'positive_prefix' => 'POSITIVE',
                    'negative_prefix' => 'NEGATIVE',
                ],
                [
                    \NumberFormatter::POSITIVE_PREFIX => 'POSITIVE',
                    \NumberFormatter::NEGATIVE_PREFIX => 'NEGATIVE',
                ],
                false,
            ],
            [
                [
                    'non_existent_constant' => 'NON_EXISTENT_VALUE',
                ],
                [],
                true,
            ],
        ];
    }

    /**
     * @dataProvider provideFormatMethodArguments
     */
    public function testFormatMethodSignatures($arguments, $expectedArguments, $exceptionExpected): void
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);

        if ($exceptionExpected) {
            $this->expectException(\BadMethodCallException::class);
        }

        $this->assertSame($expectedArguments, \call_user_func_array([$helper, 'normalizeMethodSignature'], $arguments));
    }

    public function provideFormatMethodArguments()
    {
        return [
            [
                [null, null],
                [null, []],
                false,
            ],
            [
                [null, 'en'],
                ['en', []],
                true,
            ],
            [
                [[], null],
                [null, []],
                false,
            ],
            [
                [[], 'en'],
                ['en', []],
                false,
            ],
            [
                ['en', null],
                ['en', []],
                false,
            ],
        ];
    }

    public function testFormatMethodWithDefaultArguments(): void
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);
        $method = new \ReflectionMethod($helper, 'format');
        $method->setAccessible(true);

        $this->assertSame('10', $method->invoke($helper, 10, \NumberFormatter::DECIMAL, [], []));
        $this->assertSame('10', $method->invoke($helper, 10, \NumberFormatter::DECIMAL, [], [], 'fr'));
        $this->assertSame('10', $method->invoke($helper, 10, \NumberFormatter::DECIMAL, [], [], []));
    }

    private function createLocaleDetectorMock()
    {
        $localeDetector = $this->createMock(LocaleDetectorInterface::class);
        $localeDetector
            ->expects($this->any())
            ->method('getLocale')->willReturn('en')
        ;

        return $localeDetector;
    }
}
