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

use Sonata\IntlBundle\SonataIntlBundle;

class SonataIntlBundleTest extends \PHPUnit_Framework_TestCase
{
    public function getVersions()
    {
        return array(
            array('2.0.1', '2.0.1', true, true),
            array('2.0.2', '2.0.1', true, true),
            array('2.1.1-DEV', '2.1.1', false, true),
            array('2.1.0-RC1', '2.1.0', false, true),
            array('2.1.0-RC1', '2.1.1', false, false),
        );
    }

    /**
     * @dataProvider getVersions
     */
    public function testSymfonyVersion($currentVersion, $minVersion, $versionExpected, $versionBundle)
    {
        $this->assertEquals($versionExpected, version_compare($currentVersion, $minVersion, '>='));
        $this->assertEquals($versionBundle, version_compare(SonataIntlBundle::getSymfonyVersion($currentVersion), $minVersion, '>='));
    }
}
