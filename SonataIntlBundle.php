<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\IntlBundle;

use Sonata\IntlBundle\DependencyInjection\Compiler\TimezoneDetectorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SonataIntlBundle extends Bundle
{
    /**
     * Returns a cleaned version number
     *
     * @static
     * @param $version
     * @return string
     */
    public static function getSymfonyVersion($version)
    {
        return implode('.', array_slice(array_map(function($val) { return (int) $val; }, explode('.', $version)), 0, 3));
    }
}
