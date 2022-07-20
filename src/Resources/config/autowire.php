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

use Sonata\IntlBundle\Helper\DateTimeFormatter;
use Sonata\IntlBundle\Helper\DateTimeFormatterInterface;
use Sonata\IntlBundle\Helper\Localizer;
use Sonata\IntlBundle\Helper\LocalizerInterface;
use Sonata\IntlBundle\Helper\NumberFormatter;
use Sonata\IntlBundle\Helper\NumberFormatterInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->alias(DateTimeFormatter::class, 'sonata.intl.helper.datetime')
        ->alias(Localizer::class, 'sonata.intl.helper.locale')
        ->alias(NumberFormatter::class, 'sonata.intl.helper.number')

        ->alias(DateTimeFormatterInterface::class, 'sonata.intl.helper.datetime')
        ->alias(LocalizerInterface::class, 'sonata.intl.helper.locale')
        ->alias(NumberFormatterInterface::class, 'sonata.intl.helper.number');
};
