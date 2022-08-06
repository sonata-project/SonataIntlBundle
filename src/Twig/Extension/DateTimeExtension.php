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

use Sonata\IntlBundle\Twig\DateTimeRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * DateTimeExtension extends Twig with localized date/time capabilities.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 */
final class DateTimeExtension extends AbstractExtension
{
    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('sonata_format_date', [DateTimeRuntime::class, 'formatDate'], ['is_safe' => ['html']]),
            new TwigFilter('sonata_format_time', [DateTimeRuntime::class, 'formatTime'], ['is_safe' => ['html']]),
            new TwigFilter('sonata_format_datetime', [DateTimeRuntime::class, 'formatDatetime'], ['is_safe' => ['html']]),
        ];
    }
}
