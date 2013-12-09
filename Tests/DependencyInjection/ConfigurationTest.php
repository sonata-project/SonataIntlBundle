<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\IntlBundle\Tests;

use Sonata\IntlBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testOptions()
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), array(
            array (
                'timezone' => array(
                    'default' => 'Europe/Paris'
                )
            )
        ));

        $expected = array(
            'locale'   => false,
            'timezone' => array(
                'detectors' => array(),
                'default' => 'Europe/Paris',
                'locales' => array(),
            ),
        );

        $this->assertEquals($expected, $config);
    }
}
