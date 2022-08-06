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

use Sonata\IntlBundle\Twig\NumberRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * NumberExtension extends Twig with some filters to format numbers according
 * to locale and/or custom options.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
final class NumberExtension extends AbstractExtension
{
    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('sonata_number_format_currency', [NumberRuntime::class, 'formatCurrency'], ['is_safe' => ['html']]),
            new TwigFilter('sonata_number_format_decimal', [NumberRuntime::class, 'formatDecimal'], ['is_safe' => ['html']]),
            new TwigFilter('sonata_number_format_scientific', [NumberRuntime::class, 'formatScientific'], ['is_safe' => ['html']]),
            new TwigFilter('sonata_number_format_spellout', [NumberRuntime::class, 'formatSpellout'], ['is_safe' => ['html']]),
            new TwigFilter('sonata_number_format_percent', [NumberRuntime::class, 'formatPercent'], ['is_safe' => ['html']]),
            new TwigFilter('sonata_number_format_duration', [NumberRuntime::class, 'formatDuration'], ['is_safe' => ['html']]),
            new TwigFilter('sonata_number_format_ordinal', [NumberRuntime::class, 'formatOrdinal'], ['is_safe' => ['html']]),
        ];
    }
}
