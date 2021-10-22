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

use Sonata\IntlBundle\Templating\Helper\DateTimeHelper;
use Sonata\IntlBundle\Templating\Helper\LocaleHelper;
use Sonata\IntlBundle\Templating\Helper\NumberHelper;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->alias(DateTimeHelper::class, 'sonata.intl.templating.helper.datetime')
        ->alias(LocaleHelper::class, 'sonata.intl.templating.helper.locale')
        ->alias(NumberHelper::class, 'sonata.intl.templating.helper.number');
};
