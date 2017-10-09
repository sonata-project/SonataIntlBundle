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

use Sonata\IntlBundle\Templating\Helper\NumberHelper;
use Sonata\IntlBundle\Tests\Helpers\PHPUnit_Framework_TestCase;

/**
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
class NumberHelperTest extends PHPUnit_Framework_TestCase
{
    public function testLocale()
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);

        // currency
        $this->assertEquals('10,49 €', $helper->formatCurrency(10.49, 'EUR'));
        $this->assertEquals('10,50 €', $helper->formatCurrency(10.499, 'EUR'));
        $this->assertEquals('10 000,50 €', $helper->formatCurrency(10000.499, 'EUR'));

        $this->assertEquals('10,49 €', $helper->formatCurrency(10.49, 'EUR', [
            // the fraction_digits is not supported by the currency lib, https://bugs.php.net/bug.php?id=63140
            'fraction_digits' => 0,
        ]));

        // decimal
        $this->assertEquals('10', $helper->formatDecimal(10));
        $this->assertEquals('10,155', $helper->formatDecimal(10.15459));
        $this->assertEquals('1 000 000,155', $helper->formatDecimal(1000000.15459));

        // scientific
        $this->assertEquals('1E1', $helper->formatScientific(10));
        $this->assertEquals('1E3', $helper->formatScientific(1000));
        $this->assertEquals('1,0001E3', $helper->formatScientific(1000.1));
        $this->assertEquals('1,00000015459E6', $helper->formatScientific(1000000.15459));
        $this->assertEquals('1,00000015459E6', $helper->formatScientific(1000000.15459));

        // duration
        $this->assertEquals('1 000 000', $helper->formatDuration(1000000));

        // spell out
        $this->assertEquals('un', $helper->formatSpellout(1));
        $this->assertEquals('quarante-deux', $helper->formatSpellout(42));

        if (version_compare(NumberHelper::getICUDataVersion(), '52', '>=')) {
            $this->assertEquals('un million deux cent vingt-quatre mille cinq cent cinquante-sept virgule un deux cinq quatre', $helper->formatSpellout(1224557.1254));
        } else {
            $this->assertEquals('un million deux-cent-vingt-quatre-mille-cinq-cent-cinquante-sept virgule un deux cinq quatre', $helper->formatSpellout(1224557.1254));
        }

        // percent
        $this->assertEquals('10 %', $helper->formatPercent(0.1));
        $this->assertEquals('200 %', $helper->formatPercent(1.999));
        $this->assertEquals('99 %', $helper->formatPercent(0.99));

        // ordinal
        if (version_compare(NumberHelper::getICUDataVersion(), '4.8.0', '>=')) {
            $this->assertEquals('1er', $helper->formatOrdinal(1), 'ICU Version: '.NumberHelper::getICUDataVersion());
            $this->assertEquals('100e', $helper->formatOrdinal(100), 'ICU Version: '.NumberHelper::getICUDataVersion());
            $this->assertEquals('10 000e', $helper->formatOrdinal(10000), 'ICU Version: '.NumberHelper::getICUDataVersion());
        } elseif (version_compare(NumberHelper::getICUDataVersion(), '4.1.0', '>=')) {
            $this->assertEquals('1ᵉʳ', $helper->formatOrdinal(1), 'ICU Version: '.NumberHelper::getICUDataVersion());
            $this->assertEquals('100ᵉ', $helper->formatOrdinal(100), 'ICU Version: '.NumberHelper::getICUDataVersion());
            $this->assertEquals('10 000ᵉ', $helper->formatOrdinal(10000), 'ICU Version: '.NumberHelper::getICUDataVersion());
        } else {
            $this->markTestIncomplete(sprintf('Unknown ICU DATA Version, feel free to contribute ... (version: %s)', NumberHelper::getICUDataVersion()));
        }
    }

    public function testArguments()
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector, ['fraction_digits' => 2], ['negative_prefix' => 'MINUS']);

        // Check that the 'default' options are used
        $this->assertEquals('1,34', $helper->formatDecimal(1.337));
        $this->assertEquals('MINUS1,34', $helper->formatDecimal(-1.337));

        // Check that the options are overwritten
        $this->assertEquals('1,337', $helper->formatDecimal(1.337, ['fraction_digits' => 3]));
        $this->assertEquals('MIN1,34', $helper->formatDecimal(-1.337, [], ['negative_prefix' => 'MIN']));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionOnInvalidParams()
    {
        // https://wiki.php.net/rfc/internal_constructor_behaviour
        try {
            $formatter = new \NumberFormatter('FR', -1);
        } catch (\IntlException $e) {
            throw new \RuntimeException($e->getMessage());
        }

        $this->assertNull($formatter);

        $localeDetector = $this->createMock('Sonata\IntlBundle\Locale\LocaleDetectorInterface');
        $localeDetector->expects($this->any())
            ->method('getLocale')->will($this->returnValue('fr'));

        $helper = new NumberHelper('UTF-8', $localeDetector, ['fraction_digits' => 2], ['negative_prefix' => 'MINUS']);

        $helper->format(10.49, -1);
    }

    /**
     * @dataProvider provideConstantValues
     */
    public function testParseConstantValue($constantName, $expectedConstant, $exceptionExpected)
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);
        $method = new \ReflectionMethod($helper, 'parseConstantValue');
        $method->setAccessible(true);

        if ($exceptionExpected) {
            $this->setExpectedException('\InvalidArgumentException');
        }

        $this->assertEquals($expectedConstant, $method->invoke($helper, $constantName));
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
    public function testParseAttributes($attributes, $expectedAttributes, $exceptionExpected)
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);
        $method = new \ReflectionMethod($helper, 'parseAttributes');
        $method->setAccessible(true);

        if ($exceptionExpected) {
            $this->setExpectedException('\InvalidArgumentException');
        }

        $this->assertEquals($expectedAttributes, $method->invoke($helper, $attributes));
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
    public function testFormatMethodSignatures($arguments, $expectedArguments, $exceptionExpected)
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);

        if ($exceptionExpected) {
            $this->setExpectedException('\BadMethodCallException');
        }

        $this->assertEquals($expectedArguments, call_user_func_array([$helper, 'normalizeMethodSignature'], $arguments));
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
                [null, 'fr'],
                ['fr', []],
                true,
            ],
            [
                [[], null],
                [null, []],
                false,
            ],
            [
                [[], 'fr'],
                ['fr', []],
                false,
            ],
            [
                ['fr', null],
                ['fr', []],
                false,
            ],
        ];
    }

    public function testFormatMethodWithDefaultArguments()
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);
        $method = new \ReflectionMethod($helper, 'format');
        $method->setAccessible(true);

        $this->assertEquals('10', $method->invoke($helper, 10, \NumberFormatter::DECIMAL, [], []));
        $this->assertEquals('10', $method->invoke($helper, 10, \NumberFormatter::DECIMAL, [], [], 'fr'));
        $this->assertEquals('10', $method->invoke($helper, 10, \NumberFormatter::DECIMAL, [], [], []));
    }

    private function createLocaleDetectorMock()
    {
        $localeDetector = $this->createMock('Sonata\IntlBundle\Locale\LocaleDetectorInterface');
        $localeDetector
            ->expects($this->any())
            ->method('getLocale')->will($this->returnValue('fr'))
        ;

        return $localeDetector;
    }
}
