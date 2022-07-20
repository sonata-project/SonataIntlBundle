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
use Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // Use "service" function for creating references to services when dropping support for Symfony 4.4
    // Use "param" function for creating references to parameters when dropping support for Symfony 5.1

    $containerConfigurator->parameters()
        ->set('sonata.intl.templating.helper.locale.class', LocaleHelper::class)
        ->set('sonata.intl.templating.helper.number.class', NumberHelper::class)
        ->set('sonata.intl.templating.helper.datetime.class', DateTimeHelper::class);

    $containerConfigurator->services()
        ->set('sonata.intl.templating.helper.locale', '%sonata.intl.templating.helper.locale.class%')
            ->public()
            ->tag('templating.helper', [
                'alias' => 'locale',
            ])
            ->args([
                '%kernel.charset%',
                new ReferenceConfigurator('sonata.intl.locale_detector'),
            ])

        ->set('sonata.intl.templating.helper.number', '%sonata.intl.templating.helper.number.class%')
            ->public()
            ->tag('templating.helper', [
                'alias' => 'number',
            ])
            ->args([
                '%kernel.charset%',
                new ReferenceConfigurator('sonata.intl.locale_detector'),
            ])

        ->set('sonata.intl.templating.helper.datetime', '%sonata.intl.templating.helper.datetime.class%')
            ->public()
            ->tag('templating.helper', [
                'alias' => 'datetime',
            ])
            ->args([
                new ReferenceConfigurator('sonata.intl.timezone_detector'),
                '%kernel.charset%',
                new ReferenceConfigurator('sonata.intl.locale_detector'),
            ]);

    $containerConfigurator->services()
        ->alias(DateTimeHelper::class, 'sonata.intl.templating.helper.datetime')
        ->alias(LocaleHelper::class, 'sonata.intl.templating.helper.locale')
        ->alias(NumberHelper::class, 'sonata.intl.templating.helper.number');
};
