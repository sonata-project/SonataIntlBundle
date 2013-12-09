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

use Symfony\Component\Templating\Helper\Helper;
use Sonata\IntlBundle\Templating\Helper\NumberHelper;

class NumberHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testLocale()
    {
        $localeDetector = $this->getMock('Sonata\IntlBundle\Locale\LocaleDetectorInterface');
        $localeDetector->expects($this->any())
            ->method('getLocale')->will($this->returnValue('fr'));

        $helper = new NumberHelper('UTF-8', $localeDetector);

        // currency
        $this->assertEquals('10,49 €', $helper->formatCurrency(10.49, 'EUR'));
        $this->assertEquals('10,50 €', $helper->formatCurrency(10.499, 'EUR'));
        $this->assertEquals('10 000,50 €', $helper->formatCurrency(10000.499, 'EUR'));

        $this->assertEquals('10,49 €', $helper->formatCurrency(10.49, 'EUR', array(
            // the fraction_digits is not supported by the currency lib, https://bugs.php.net/bug.php?id=63140
            'fraction_digits' => 0
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
        $this->assertEquals('un million deux-cent-vingt-quatre-mille-cinq-cent-cinquante-sept virgule un deux cinq quatre', $helper->formatSpellout(1224557.1254));

        // percent
        $this->assertEquals('10 %', $helper->formatPercent(0.1));
        $this->assertEquals('200 %', $helper->formatPercent(1.999));
        $this->assertEquals('99 %', $helper->formatPercent(0.99));

        // ordinal
        if (version_compare(NumberHelper::getUCIDataVersion(), '4.8.0', '>=')) {
            $this->assertEquals('1er', $helper->formatOrdinal(1));
            $this->assertEquals('100e', $helper->formatOrdinal(100));
            $this->assertEquals('10 000e', $helper->formatOrdinal(10000));
        } elseif (version_compare(NumberHelper::getUCIDataVersion(), '4.1.0', '>=')) {
            $this->assertEquals('1ᵉʳ', $helper->formatOrdinal(1));
            $this->assertEquals('100ᵉ', $helper->formatOrdinal(100));
            $this->assertEquals('10 000ᵉ', $helper->formatOrdinal(10000));
        } else {
            $this->markTestIncomplete(sprintf('Unknown UCI DATA Version, feel free to contribute ... (version: %s)', NumberHelper::getUCIDataVersion()));
        }
    }

    public function testArguments()
    {
        $localeDetector = $this->getMock('Sonata\IntlBundle\Locale\LocaleDetectorInterface');
        $localeDetector->expects($this->any())
            ->method('getLocale')->will($this->returnValue('fr'));

        $helper = new NumberHelper('UTF-8', $localeDetector, array('fraction_digits' => 2), array('negative_prefix' => 'MINUS'));

        // Check that the 'default' options are used
        $this->assertEquals('1,34', $helper->formatDecimal(1.337));
        $this->assertEquals('MINUS1,34', $helper->formatDecimal(-1.337));

        // Check that the options are overwritten
        $this->assertEquals('1,337', $helper->formatDecimal(1.337, array('fraction_digits' => 3)));
        $this->assertEquals('MIN1,34', $helper->formatDecimal(-1.337, array(), array('negative_prefix' => 'MIN')));

        // Check that exception are thrown on non-existing class constant
        $exceptionThrown = false;
        try {
            $helper->formatDecimal(1.337, array('non_existant' => 3));
        } catch (\InvalidArgumentException $e) {
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);

        $exceptionThrown = false;
        try {
            $helper->formatDecimal(1.337, array(), array('non_existant' => 'MIN'));
        } catch (\InvalidArgumentException $e) {
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }
}
