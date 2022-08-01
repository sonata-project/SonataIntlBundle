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

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Sonata\IntlBundle\Helper\DateTimeFormatter;
use Sonata\IntlBundle\Helper\Localizer;
use Sonata\IntlBundle\Helper\NumberFormatter;
use Sonata\IntlBundle\Timezone\ChainTimezoneDetector;
use Sonata\IntlBundle\Timezone\LocaleAwareBasedTimezoneDetector;
use Sonata\IntlBundle\Timezone\UserBasedTimezoneDetector;
use Sonata\IntlBundle\Twig\DateTimeRuntime;
use Sonata\IntlBundle\Twig\Extension\DateTimeExtension;
use Sonata\IntlBundle\Twig\Extension\LocaleExtension;
use Sonata\IntlBundle\Twig\Extension\NumberExtension;
use Sonata\IntlBundle\Twig\LocaleRuntime;
use Sonata\IntlBundle\Twig\NumberRuntime;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()

        ->set('sonata.intl.helper.locale', Localizer::class)
            ->public()
            ->args([
                param('kernel.charset'),
            ])

        ->set('sonata.intl.helper.number', NumberFormatter::class)
            ->public()
            ->args([
                param('kernel.charset'),
            ])

        ->set('sonata.intl.helper.datetime', DateTimeFormatter::class)
            ->public()
            ->args([
                service('sonata.intl.timezone_detector'),
                param('kernel.charset'),
            ])

        ->set('sonata.intl.twig.extension.locale', LocaleExtension::class)
            ->private()
            ->tag('twig.extension')
            ->args([
                service('sonata.intl.helper.locale'),
            ])

        ->set('sonata.intl.twig.extension.number', NumberExtension::class)
            ->private()
            ->tag('twig.extension')
            ->args([
                service('sonata.intl.helper.number'),
            ])

        ->set('sonata.intl.twig.extension.datetime', DateTimeExtension::class)
            ->private()
            ->tag('twig.extension')
            ->args([
                service('sonata.intl.helper.datetime'),
            ])

        ->set('sonata.intl.twig.runtime.locale', LocaleRuntime::class)
            ->tag('twig.runtime')
            ->args([
                service('sonata.intl.helper.locale'),
            ])

        ->set('sonata.intl.twig.runtime.number', NumberRuntime::class)
            ->tag('twig.runtime')
            ->args([
                service('sonata.intl.helper.number'),
            ])

        ->set('sonata.intl.twig.runtime.datetime', DateTimeRuntime::class)
            ->tag('twig.runtime')
            ->args([
                service('sonata.intl.helper.datetime'),
            ])

        ->set('sonata.intl.timezone_detector.chain', ChainTimezoneDetector::class)
            ->public()
            ->args([
                abstract_arg('default timzone'),
            ])

        ->set('sonata.intl.timezone_detector.user', UserBasedTimezoneDetector::class)
            ->public()
            ->tag('sonata_intl.timezone_detector', [
                'alias' => 'user',
            ])
            ->args([
                service('security.token_storage'),
            ])

        ->set('sonata.intl.timezone_detector.locale_aware', LocaleAwareBasedTimezoneDetector::class)
            ->public()
            ->tag('sonata_intl.timezone_detector', [
                'alias' => 'locale_aware',
            ])
            ->args([
                abstract_arg('timezone map'),
            ]);
};
