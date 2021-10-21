<?php

use Sonata\IntlBundle\Templating\Helper\DateTimeHelper;
use Sonata\IntlBundle\Templating\Helper\LocaleHelper;
use Sonata\IntlBundle\Templating\Helper\NumberHelper;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // Use "service" function for creating references to services when dropping support for Symfony 4.4
    // Use "param" function for creating references to parameters when dropping support for Symfony 5.1

    $containerConfigurator->services()
        ->alias(DateTimeHelper::class, 'sonata.intl.templating.helper.datetime')
        ->alias(LocaleHelper::class, 'sonata.intl.templating.helper.locale')
        ->alias(NumberHelper::class, 'sonata.intl.templating.helper.number')
    ;
};
