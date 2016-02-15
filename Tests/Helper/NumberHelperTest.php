<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Sonata\IntlBundle\Tests\Helper;

use Sonata\IntlBundle\Templating\Helper\NumberHelper;

/**
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
class NumberHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testLocale()
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);

        // currency
        $this->assertEquals('10,49 €', $helper->formatCurrency(10.49, 'EUR'));
        $this->assertEquals('10,50 €', $helper->formatCurrency(10.499, 'EUR'));
        $this->assertEquals('10 000,50 €', $helper->formatCurrency(10000.499, 'EUR'));

        $this->assertEquals('10,49 €', $helper->formatCurrency(10.49, 'EUR', array(
            // the fraction_digits is not supported by the currency lib, https://bugs.php.net/bug.php?id=63140
            'fraction_digits' => 0,
        )));

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
        $helper = new NumberHelper('UTF-8', $localeDetector, array('fraction_digits' => 2), array('negative_prefix' => 'MINUS'));

        // Check that the 'default' options are used
        $this->assertEquals('1,34', $helper->formatDecimal(1.337));
        $this->assertEquals('MINUS1,34', $helper->formatDecimal(-1.337));

        // Check that the options are overwritten
        $this->assertEquals('1,337', $helper->formatDecimal(1.337, array('fraction_digits' => 3)));
        $this->assertEquals('MIN1,34', $helper->formatDecimal(-1.337, array(), array('negative_prefix' => 'MIN')));
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

        $localeDetector = $this->getMock('Sonata\IntlBundle\Locale\LocaleDetectorInterface');
        $localeDetector->expects($this->any())
            ->method('getLocale')->will($this->returnValue('fr'));

        $helper = new NumberHelper('UTF-8', $localeDetector, array('fraction_digits' => 2), array('negative_prefix' => 'MINUS'));

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
        return array(
            array('positive_prefix', \NumberFormatter::POSITIVE_PREFIX, false),
            array('non_existent_constant', \NumberFormatter::NEGATIVE_PREFIX, true),
        );
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
        return array(
            array(
                array(
                    'positive_prefix' => 'POSITIVE',
                    'negative_prefix' => 'NEGATIVE',
                ),
                array(
                    \NumberFormatter::POSITIVE_PREFIX => 'POSITIVE',
                    \NumberFormatter::NEGATIVE_PREFIX => 'NEGATIVE',
                ),
                false,
            ),
            array(
                array(
                    'non_existent_constant' => 'NON_EXISTENT_VALUE',
                ),
                array(),
                true,
            ),
        );
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

        $this->assertEquals($expectedArguments, call_user_func_array(array($helper, 'normalizeMethodSignature'), $arguments));
    }

    public function provideFormatMethodArguments()
    {
        return array(
            array(
                array(null, null),
                array(null, array()),
                false,
            ),
            array(
                array(null, 'fr'),
                array('fr', array()),
                true,
            ),
            array(
                array(array(), null),
                array(null, array()),
                false,
            ),
            array(
                array(array(), 'fr'),
                array('fr', array()),
                false,
            ),
            array(
                array('fr', null),
                array('fr', array()),
                false,
            ),
        );
    }

    public function testFormatMethodWithDefaultArguments()
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);
        $method = new \ReflectionMethod($helper, 'format');
        $method->setAccessible(true);

        $this->assertEquals('10', $method->invoke($helper, 10, \NumberFormatter::DECIMAL, array(), array()));
        $this->assertEquals('10', $method->invoke($helper, 10, \NumberFormatter::DECIMAL, array(), array(), 'fr'));
        $this->assertEquals('10', $method->invoke($helper, 10, \NumberFormatter::DECIMAL, array(), array(), array()));
    }

    private function createLocaleDetectorMock()
    {
        $localeDetector = $this->getMock('Sonata\IntlBundle\Locale\LocaleDetectorInterface');
        $localeDetector
            ->expects($this->any())
            ->method('getLocale')->will($this->returnValue('fr'))
        ;

        return $localeDetector;
    }
}
