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
use Sonata\IntlBundle\Helper\NumberHelper;
use Sonata\IntlBundle\Locale\LocaleDetectorInterface;
use Sonata\IntlBundle\Twig\Extension\NumberExtension;

/**
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
class NumberExtensionTest extends TestCase
{
    /**
     * @group legacy
     *
     * @dataProvider provideFormatArguments
     */
    public function testFormat($methodName, $testData)
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);
        $extension = new NumberExtension($helper);

        foreach ($testData as $data) {
            [$methodArguments, $expectedResult] = $data;

            static::assertSame($expectedResult, \call_user_func_array([$extension, $methodName], $methodArguments));
        }
    }

    public function provideFormatArguments()
    {
        return [
            [
                'formatCurrency',
                [
                    [
                        [10.49, 'EUR'],
                        '€10.49',
                    ],
                    [
                        [10.499, 'EUR'],
                        '€10.50',
                    ],
                    [
                        [10000.499, 'EUR'],
                        '€10,000.50',
                    ],
                    [
                        [
                            10000.499,
                            'EUR',
                            [],
                            [],
                            ['MONETARY_GROUPING_SEPARATOR_SYMBOL' => 'DOT'],
                        ],
                        '€10DOT000.50',
                    ],
                ],
            ],
            [
                'formatDecimal',
                [
                    [
                        [10],
                        '10',
                    ],
                    [
                        [10.15459],
                        '10.155',
                    ],
                    [
                        [1_000_000.15459],
                        '1,000,000.155',
                    ],
                    [
                        [
                            1_000_000.15459,
                            [],
                            [],
                            ['GROUPING_SEPARATOR_SYMBOL' => 'DOT'],
                        ],
                        '1DOT000DOT000.155',
                    ],
                ],
            ],
            [
                'formatScientific',
                [
                    [
                        [10],
                        '1E1',
                    ],
                    [
                        [1000],
                        '1E3',
                    ],
                    [
                        [1000.1],
                        '1.0001E3',
                    ],
                    [
                        [1_000_000.15459],
                        '1.00000015459E6',
                    ],
                ],
            ],
            [
                'formatDuration',
                [
                    [
                        [1_000_000],
                        '277:46:40',
                    ],
                ],
            ],
            [
                'formatPercent',
                [
                    [
                        [0.1],
                        '10%',
                    ],
                    [
                        [1.999],
                        '200%',
                    ],
                    [
                        [0.99],
                        '99%',
                    ],
                ],
            ],
        ];
    }

    /**
     * @group legacy
     */
    public function testFormatOrdinal()
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);
        $extension = new NumberExtension($helper);

        static::assertSame('1st', $extension->formatOrdinal(1), 'ICU Version: '.NumberHelper::getICUDataVersion());
        static::assertSame('100th', $extension->formatOrdinal(100), 'ICU Version: '.NumberHelper::getICUDataVersion());
        static::assertSame('10,000th', $extension->formatOrdinal(10000), 'ICU Version: '.NumberHelper::getICUDataVersion());
    }

    /**
     * @group legacy
     */
    public function testFormatSpellout()
    {
        $localeDetector = $this->createLocaleDetectorMock();
        $helper = new NumberHelper('UTF-8', $localeDetector);
        $extension = new NumberExtension($helper);

        static::assertSame('one', $extension->formatSpellout(1));
        static::assertSame('forty-two', $extension->formatSpellout(42));
        static::assertSame('one million two hundred twenty-four thousand five hundred fifty-seven point one two five four', $extension->formatSpellout(1_224_557.1254));
    }

    private function createLocaleDetectorMock()
    {
        $localeDetector = $this->createMock(LocaleDetectorInterface::class);
        $localeDetector
            ->method('getLocale')->willReturn('en');

        return $localeDetector;
    }
}
