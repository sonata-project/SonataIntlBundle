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

namespace Sonata\IntlBundle\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Sonata\IntlBundle\Helper\NumberFormatter;
use Sonata\IntlBundle\Twig\NumberRuntime;

/**
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
class NumberRuntimeTest extends TestCase
{
    /**
     * @param array<string, int|float> $attributes
     * @param array<string, string>    $textAttributes
     * @param array<string, string>    $symbols
     *
     * @dataProvider provideFormatCurrencyArguments
     */
    public function testFormatCurrency(
        string $expectedResult,
        string|float|int $number,
        string $currency,
        array $attributes = [],
        array $textAttributes = [],
        array $symbols = []
    ): void {
        $helper = new NumberFormatter('UTF-8');
        $helper->setLocale('en');
        $extension = new NumberRuntime($helper);

        static::assertSame($expectedResult, $extension->formatCurrency($number, $currency, $attributes, $textAttributes, $symbols));
    }

    /**
     * @return array<array{0: string, 1: string|float|int, 2: string, 3?: array<string, int|float>, 4?: array<string, string>, 5?: array<string, string>}>
     */
    public function provideFormatCurrencyArguments(): array
    {
        return [
            [
                '€10.49',
                10.49,
                'EUR',
            ],
            [
                '€10.50',
                10.499,
                'EUR',
            ],
            [
                '€10,000.50',
                10000.499,
                'EUR',
            ],
            [
                '€10DOT000.50',
                10000.499,
                'EUR',
                [],
                [],
                ['MONETARY_GROUPING_SEPARATOR_SYMBOL' => 'DOT'],
            ],
        ];
    }

    /**
     * @param array<string, int|float> $attributes
     * @param array<string, string>    $textAttributes
     * @param array<string, string>    $symbols
     *
     * @dataProvider provideFormatDecimalArguments
     */
    public function testFormatDecimal(
        string $expectedResult,
        string|float|int $number,
        array $attributes = [],
        array $textAttributes = [],
        array $symbols = []
    ): void {
        $helper = new NumberFormatter('UTF-8');
        $helper->setLocale('en');
        $extension = new NumberRuntime($helper);

        static::assertSame($expectedResult, $extension->formatDecimal($number, $attributes, $textAttributes, $symbols));
    }

    /**
     * @return array<array{0: string, 1: string|float|int, 2?: array<string, int|float>, 3?: array<string, string>, 4?: array<string, string>}>
     */
    public function provideFormatDecimalArguments(): array
    {
        return [
            [
                '10',
                10,
            ],
            [
                '10.155',
                10.15459,
            ],
            [
                '1,000,000.155',
                1_000_000.15459,
            ],
            [
                '1DOT000DOT000.155',
                1_000_000.15459,
                [],
                [],
                ['GROUPING_SEPARATOR_SYMBOL' => 'DOT'],
            ],
        ];
    }

    /**
     * @param array<string, int|float> $attributes
     * @param array<string, string>    $textAttributes
     * @param array<string, string>    $symbols
     *
     * @dataProvider provideFormatScientificArguments
     */
    public function testFormatScientific(
        string $expectedResult,
        string|float|int $number,
        array $attributes = [],
        array $textAttributes = [],
        array $symbols = []
    ): void {
        $helper = new NumberFormatter('UTF-8');
        $helper->setLocale('en');
        $extension = new NumberRuntime($helper);

        static::assertSame($expectedResult, $extension->formatScientific($number, $attributes, $textAttributes, $symbols));
    }

    /**
     * @return array<array{0: string, 1: string|float|int, 2?: array<string, int|float>, 3?: array<string, string>, 4?: array<string, string>}>
     */
    public function provideFormatScientificArguments(): array
    {
        return [
            [
                '1E1',
                10,
            ],
            [
                '1E3',
                1000,
            ],
            [
                '1.0001E3',
                1000.1,
            ],
            [
                '1.00000015459E6',
                1_000_000.15459,
            ],
        ];
    }

    /**
     * @param array<string, int|float> $attributes
     * @param array<string, string>    $textAttributes
     * @param array<string, string>    $symbols
     *
     * @dataProvider provideFormatDurationArguments
     */
    public function testFormatDuration(
        string $expectedResult,
        string|float|int $number,
        array $attributes = [],
        array $textAttributes = [],
        array $symbols = []
    ): void {
        $helper = new NumberFormatter('UTF-8');
        $helper->setLocale('en');
        $extension = new NumberRuntime($helper);

        static::assertSame($expectedResult, $extension->formatDuration($number, $attributes, $textAttributes, $symbols));
    }

    /**
     * @return array<array{0: string, 1: string|float|int, 2?: array<string, int|float>, 3?: array<string, string>, 4?: array<string, string>}>
     */
    public function provideFormatDurationArguments(): array
    {
        return [
            [
                '277:46:40',
                1_000_000,
            ],
        ];
    }

    /**
     * @param array<string, int|float> $attributes
     * @param array<string, string>    $textAttributes
     * @param array<string, string>    $symbols
     *
     * @dataProvider provideFormatPercentArguments
     */
    public function testFormatPercent(
        string $expectedResult,
        string|float|int $number,
        array $attributes = [],
        array $textAttributes = [],
        array $symbols = []
    ): void {
        $helper = new NumberFormatter('UTF-8');
        $helper->setLocale('en');
        $extension = new NumberRuntime($helper);

        static::assertSame($expectedResult, $extension->formatPercent($number, $attributes, $textAttributes, $symbols));
    }

    /**
     * @return array<array{0: string, 1: string|float|int, 2?: array<string, int|float>, 3?: array<string, string>, 4?: array<string, string>}>
     */
    public function provideFormatPercentArguments(): array
    {
        return [
            [
                '10%',
                0.1,
            ],
            [
                '200%',
                1.999,
            ],
            [
                '99%',
                0.99,
            ],
        ];
    }

    public function testFormatOrdinal(): void
    {
        $helper = new NumberFormatter('UTF-8');
        $helper->setLocale('en');
        $extension = new NumberRuntime($helper);

        static::assertSame('1st', $extension->formatOrdinal(1), 'ICU Version: '.NumberFormatter::getICUDataVersion());
        static::assertSame('100th', $extension->formatOrdinal(100), 'ICU Version: '.NumberFormatter::getICUDataVersion());
        static::assertSame('10,000th', $extension->formatOrdinal(10000), 'ICU Version: '.NumberFormatter::getICUDataVersion());
    }

    public function testFormatSpellout(): void
    {
        $helper = new NumberFormatter('UTF-8');
        $helper->setLocale('en');
        $extension = new NumberRuntime($helper);

        static::assertSame('one', $extension->formatSpellout(1));
        static::assertSame('forty-two', $extension->formatSpellout(42));
        static::assertSame('one million two hundred twenty-four thousand five hundred fifty-seven point one two five four', $extension->formatSpellout(1_224_557.1254));
    }
}
