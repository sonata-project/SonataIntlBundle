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

namespace Sonata\IntlBundle\Twig\Extension;

use Sonata\IntlBundle\Twig\LocaleRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * LocaleExtension extends Twig with local capabilities.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 */
class LocaleExtension extends AbstractExtension
{
    /**
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('sonata_country', [LocaleRuntime::class, 'country'], ['is_safe' => ['html']]),
            new TwigFilter('sonata_locale', [LocaleRuntime::class, 'locale'], ['is_safe' => ['html']]),
            new TwigFilter('sonata_language', [LocaleRuntime::class, 'language'], ['is_safe' => ['html']]),
        ];
    }
}
