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

use Sonata\IntlBundle\Helper\DateTimeHelper;
use Sonata\IntlBundle\Helper\LocaleHelper;
use Sonata\IntlBundle\Helper\NumberHelper;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->alias(DateTimeHelper::class, 'sonata.intl.helper.datetime')
        ->alias(LocaleHelper::class, 'sonata.intl.helper.locale')
        ->alias(NumberHelper::class, 'sonata.intl.helper.number');
};
