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

namespace Sonata\IntlBundle\Tests\Twig\Extension;

use Sonata\IntlBundle\Templating\Helper\NumberHelper;
use Sonata\IntlBundle\Twig\Extension\NumberExtension;

/**
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
class NumberExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideFormatArguments
     */
    public function testFormat($methodName, $testData)
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);
        $extension = new NumberExtension($helper);

        foreach ($testData as $data) {
            list($methodArguments, $expectedResult) = $data;

            $this->assertEquals($expectedResult, call_user_func_array(array($extension, $methodName), $methodArguments));
        }
    }

    public function provideFormatArguments()
    {
        return array(
            array(
                'formatCurrency',
                array(
                    array(
                        array(10.49, 'EUR'),
                        '10,49 €',
                    ),
                    array(
                        array(10.499, 'EUR'),
                        '10,50 €',
                    ),
                    array(
                        array(10000.499, 'EUR'),
                        '10 000,50 €',
                    ),
                    array(
                        array(
                            10000.499,
                            'EUR',
                            array(),
                            array(),
                            array('MONETARY_GROUPING_SEPARATOR_SYMBOL' => 'DOT'),
                        ),
                        '10DOT000,50 €',
                    ),
                ),
            ),
            array(
                'formatDecimal',
                array(
                    array(
                        array(10),
                        '10',
                    ),
                    array(
                        array(10.15459),
                        '10,155',
                    ),
                    array(
                        array(1000000.15459),
                        '1 000 000,155',
                    ),
                    array(
                        array(
                            1000000.15459,
                            array(),
                            array(),
                            array('GROUPING_SEPARATOR_SYMBOL' => 'DOT'),
                        ),
                        '1DOT000DOT000,155',
                    ),
                ),
            ),
            array(
                'formatScientific',
                array(
                    array(
                        array(10),
                        '1E1',
                    ),
                    array(
                        array(1000),
                        '1E3',
                    ),
                    array(
                        array(1000.1),
                        '1,0001E3',
                    ),
                    array(
                        array(1000000.15459),
                        '1,00000015459E6',
                    ),
                ),
            ),
            array(
                'formatDuration',
                array(
                    array(
                        array(1000000),
                        '1 000 000',
                    ),
                ),
            ),
            array(
                'formatPercent',
                array(
                    array(
                        array(0.1),
                        '10 %',
                    ),
                    array(
                        array(1.999),
                        '200 %',
                    ),
                    array(
                        array(0.99),
                        '99 %',
                    ),
                ),
            ),
        );
    }

    public function testFormatOrdinal()
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);
        $extension = new NumberExtension($helper);

        if (version_compare(NumberHelper::getICUDataVersion(), '4.8.0', '>=')) {
            $this->assertEquals('1er', $extension->formatOrdinal(1), 'ICU Version: '.NumberHelper::getICUDataVersion());
            $this->assertEquals('100e', $extension->formatOrdinal(100), 'ICU Version: '.NumberHelper::getICUDataVersion());
            $this->assertEquals('10 000e', $extension->formatOrdinal(10000), 'ICU Version: '.NumberHelper::getICUDataVersion());
        } elseif (version_compare(NumberHelper::getICUDataVersion(), '4.1.0', '>=')) {
            $this->assertEquals('1ᵉʳ', $extension->formatOrdinal(1), 'ICU Version: '.NumberHelper::getICUDataVersion());
            $this->assertEquals('100ᵉ', $extension->formatOrdinal(100), 'ICU Version: '.NumberHelper::getICUDataVersion());
            $this->assertEquals('10 000ᵉ', $extension->formatOrdinal(10000), 'ICU Version: '.NumberHelper::getICUDataVersion());
        } else {
            $this->markTestIncomplete(sprintf('Unknown ICU DATA Version, feel free to contribute ... (version: %s)', NumberHelper::getICUDataVersion()));
        }
    }

    public function testFormatSpellout()
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);
        $extension = new NumberExtension($helper);

        $this->assertEquals('un', $extension->formatSpellout(1));
        $this->assertEquals('quarante-deux', $extension->formatSpellout(42));

        if (version_compare(NumberHelper::getICUDataVersion(), '52', '>=')) {
            $this->assertEquals('un million deux cent vingt-quatre mille cinq cent cinquante-sept virgule un deux cinq quatre', $extension->formatSpellout(1224557.1254));
        } else {
            $this->assertEquals('un million deux-cent-vingt-quatre-mille-cinq-cent-cinquante-sept virgule un deux cinq quatre', $extension->formatSpellout(1224557.1254));
        }
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
