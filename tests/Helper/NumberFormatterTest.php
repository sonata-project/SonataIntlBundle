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
use Sonata\IntlBundle\Helper\NumberFormatter;

/**
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
final class NumberFormatterTest extends TestCase
{
    public function testLocale(): void
    {
        $helper = new NumberFormatter('UTF-8');
        $helper->setLocale('en');

        // currency
        static::assertSame('€10.49', $helper->formatCurrency(10.49, 'EUR'));
        static::assertSame('€10.50', $helper->formatCurrency(10.499, 'EUR'));
        static::assertSame('€10,000.50', $helper->formatCurrency(10000.499, 'EUR'));
        static::assertSame('€10.49', $helper->formatCurrency('10.49', 'EUR'));
        static::assertSame('€10', $helper->formatCurrency(10.49, 'EUR', [
            'fraction_digits' => 0,
        ]));

        // decimal
        static::assertSame('10', $helper->formatDecimal(10));
        static::assertSame('10.155', $helper->formatDecimal(10.15459));
        static::assertSame('1,000,000.155', $helper->formatDecimal(1_000_000.15459));
        static::assertSame('1,000,000.155', $helper->formatDecimal('1000000.15459'));

        // scientific
        static::assertSame('1E1', $helper->formatScientific(10));
        static::assertSame('1E3', $helper->formatScientific(1000));
        static::assertSame('1.0001E3', $helper->formatScientific(1000.1));
        static::assertSame('1.00000015459E6', $helper->formatScientific(1_000_000.15459));
        static::assertSame('1.00000015459E6', $helper->formatScientific(1_000_000.15459));
        static::assertSame('1.00000015459E6', $helper->formatScientific('1000000.15459'));

        // duration
        static::assertSame('277:46:40', $helper->formatDuration(1_000_000));

        // spell out
        static::assertSame('one', $helper->formatSpellout(1));
        static::assertSame('forty-two', $helper->formatSpellout(42));
        static::assertSame('one million two hundred twenty-four thousand five hundred fifty-seven point one two five four', $helper->formatSpellout(1_224_557.1254));

        // percent
        static::assertSame('10%', $helper->formatPercent(0.1));
        static::assertSame('200%', $helper->formatPercent(1.999));
        static::assertSame('99%', $helper->formatPercent(0.99));
        static::assertSame('99%', $helper->formatPercent('0.99'));

        // ordinal
        static::assertSame('1st', $helper->formatOrdinal(1), 'ICU Version: '.NumberFormatter::getICUDataVersion());
        static::assertSame('100th', $helper->formatOrdinal(100), 'ICU Version: '.NumberFormatter::getICUDataVersion());
        static::assertSame('10,000th', $helper->formatOrdinal(10000), 'ICU Version: '.NumberFormatter::getICUDataVersion());
        static::assertSame('10,000th', $helper->formatOrdinal('10000'), 'ICU Version: '.NumberFormatter::getICUDataVersion());
    }

    public function testArguments(): void
    {
        $helper = new NumberFormatter('UTF-8', ['fraction_digits' => 2], ['negative_prefix' => 'MINUS']);
        $helper->setLocale('en');

        // Check that the 'default' options are used
        static::assertSame('1.34', $helper->formatDecimal(1.337));
        static::assertSame('MINUS1.34', $helper->formatDecimal(-1.337));

        // Check that the options are overwritten
        static::assertSame('1.337', $helper->formatDecimal(1.337, ['fraction_digits' => 3]));
        static::assertSame('MIN1.34', $helper->formatDecimal(-1.337, [], ['negative_prefix' => 'MIN']));
    }

    public function testExceptionOnInvalidParams(): void
    {
        $helper = new NumberFormatter('UTF-8', ['fraction_digits' => 2], ['negative_prefix' => 'MINUS']);
        $helper->setLocale('en');

        $this->expectException(\IntlException::class);

        $helper->format(10.49, -1);
    }

    /**
     * @dataProvider provideConstantValues
     */
    public function testParseConstantValue(string $constantName, int $expectedConstant, bool $exceptionExpected): void
    {
        $helper = new NumberFormatter('UTF-8');
        $helper->setLocale('en');
        $method = new \ReflectionMethod($helper, 'parseConstantValue');
        $method->setAccessible(true);

        if ($exceptionExpected) {
            $this->expectException(\InvalidArgumentException::class);
        }

        static::assertSame($expectedConstant, $method->invoke($helper, $constantName));
    }

    /**
     * @return array<array{string, int, bool}>
     */
    public function provideConstantValues(): array
    {
        return [
            ['positive_prefix', \NumberFormatter::POSITIVE_PREFIX, false],
            ['non_existent_constant', \NumberFormatter::NEGATIVE_PREFIX, true],
        ];
    }

    /**
     * @param array<string, string> $attributes
     * @param array<int, string>    $expectedAttributes
     *
     * @dataProvider provideAttributeValues
     */
    public function testParseAttributes(array $attributes, array $expectedAttributes, bool $exceptionExpected): void
    {
        $helper = new NumberFormatter('UTF-8');
        $helper->setLocale('en');
        $method = new \ReflectionMethod($helper, 'parseAttributes');
        $method->setAccessible(true);

        if ($exceptionExpected) {
            $this->expectException(\InvalidArgumentException::class);
        }

        static::assertSame($expectedAttributes, $method->invoke($helper, $attributes));
    }

    /**
     * @return array<array{array<string, string>, array<int, string>, bool}>
     */
    public function provideAttributeValues(): array
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
     * @param array<mixed> $arguments
     * @param array<mixed> $expectedArguments
     *
     * @dataProvider provideFormatMethodArguments
     */
    public function testFormatMethodSignatures(array $arguments, array $expectedArguments, bool $exceptionExpected): void
    {
        $helper = new NumberFormatter('UTF-8');
        $helper->setLocale('en');

        if ($exceptionExpected) {
            $this->expectException(\BadMethodCallException::class);
        }

        static::assertSame($expectedArguments, \call_user_func_array([$helper, 'normalizeMethodSignature'], $arguments));
    }

    /**
     * @return array<array{array<mixed>, array<mixed>, bool}>
     */
    public function provideFormatMethodArguments(): array
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
        $helper = new NumberFormatter('UTF-8');
        $helper->setLocale('en');
        $method = new \ReflectionMethod($helper, 'format');
        $method->setAccessible(true);

        static::assertSame('10', $method->invoke($helper, 10, \NumberFormatter::DECIMAL, [], []));
        static::assertSame('10', $method->invoke($helper, 10, \NumberFormatter::DECIMAL, [], [], [], 'fr'));
        static::assertSame('10', $method->invoke($helper, 10, \NumberFormatter::DECIMAL, [], [], []));
    }
}
