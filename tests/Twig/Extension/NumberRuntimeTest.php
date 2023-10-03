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
     * @dataProvider provideFormatCurrencyCases
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
     * @return iterable<array{0: string, 1: string|float|int, 2: string, 3?: array<string, int|float>, 4?: array<string, string>, 5?: array<string, string>}>
     */
    public function provideFormatCurrencyCases(): iterable
    {
        yield [
            '€10.49',
            10.49,
            'EUR',
        ];
        yield [
            '€10.50',
            10.499,
            'EUR',
        ];
        yield [
            '€10,000.50',
            10000.499,
            'EUR',
        ];
        yield [
            '€10DOT000.50',
            10000.499,
            'EUR',
            [],
            [],
            ['MONETARY_GROUPING_SEPARATOR_SYMBOL' => 'DOT'],
        ];
    }

    /**
     * @param array<string, int|float> $attributes
     * @param array<string, string>    $textAttributes
     * @param array<string, string>    $symbols
     *
     * @dataProvider provideFormatDecimalCases
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
     * @return iterable<array{0: string, 1: string|float|int, 2?: array<string, int|float>, 3?: array<string, string>, 4?: array<string, string>}>
     */
    public function provideFormatDecimalCases(): iterable
    {
        yield [
            '10',
            10,
        ];
        yield [
            '10.155',
            10.15459,
        ];
        yield [
            '1,000,000.155',
            1_000_000.15459,
        ];
        yield [
            '1DOT000DOT000.155',
            1_000_000.15459,
            [],
            [],
            ['GROUPING_SEPARATOR_SYMBOL' => 'DOT'],
        ];
    }

    /**
     * @param array<string, int|float> $attributes
     * @param array<string, string>    $textAttributes
     * @param array<string, string>    $symbols
     *
     * @dataProvider provideFormatScientificCases
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
     * @return iterable<array{0: string, 1: string|float|int, 2?: array<string, int|float>, 3?: array<string, string>, 4?: array<string, string>}>
     */
    public function provideFormatScientificCases(): iterable
    {
        yield [
            '1E1',
            10,
        ];
        yield [
            '1E3',
            1000,
        ];
        yield [
            '1.0001E3',
            1000.1,
        ];
        yield [
            '1.00000015459E6',
            1_000_000.15459,
        ];
    }

    /**
     * @param array<string, int|float> $attributes
     * @param array<string, string>    $textAttributes
     * @param array<string, string>    $symbols
     *
     * @dataProvider provideFormatDurationCases
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
     * @return iterable<array{0: string, 1: string|float|int, 2?: array<string, int|float>, 3?: array<string, string>, 4?: array<string, string>}>
     */
    public function provideFormatDurationCases(): iterable
    {
        yield [
            '277:46:40',
            1_000_000,
        ];
    }

    /**
     * @param array<string, int|float> $attributes
     * @param array<string, string>    $textAttributes
     * @param array<string, string>    $symbols
     *
     * @dataProvider provideFormatPercentCases
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
     * @return iterable<array{0: string, 1: string|float|int, 2?: array<string, int|float>, 3?: array<string, string>, 4?: array<string, string>}>
     */
    public function provideFormatPercentCases(): iterable
    {
        yield [
            '10%',
            0.1,
        ];
        yield [
            '200%',
            1.999,
        ];
        yield [
            '99%',
            0.99,
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
