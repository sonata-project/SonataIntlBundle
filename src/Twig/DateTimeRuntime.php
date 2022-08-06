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

namespace Sonata\IntlBundle\Twig;

use Sonata\IntlBundle\Helper\DateTimeFormatterInterface;
use Twig\Extension\RuntimeExtensionInterface;

final class DateTimeRuntime implements RuntimeExtensionInterface
{
    public function __construct(private DateTimeFormatterInterface $helper)
    {
    }

    public function formatDate(
        \DateTimeInterface|string|int $date,
        ?string $pattern = null,
        ?string $locale = null,
        ?string $timezone = null,
        ?int $dateType = null
    ): string {
        if (null !== $pattern) {
            return $this->helper->format($date, $pattern, $locale, $timezone);
        }

        return $this->helper->formatDate($date, $locale, $timezone, $dateType);
    }

    public function formatTime(
        \DateTimeInterface|string|int $time,
        ?string $pattern = null,
        ?string $locale = null,
        ?string $timezone = null,
        ?int $timeType = null
    ): string {
        if (null !== $pattern) {
            return $this->helper->format($time, $pattern, $locale, $timezone);
        }

        return $this->helper->formatTime($time, $locale, $timezone, $timeType);
    }

    public function formatDatetime(
        \DateTimeInterface|string|int $time,
        ?string $pattern = null,
        ?string $locale = null,
        ?string $timezone = null,
        ?int $dateType = null,
        ?int $timeType = null
    ): string {
        if (null !== $pattern) {
            return $this->helper->format($time, $pattern, $locale, $timezone);
        }

        return $this->helper->formatDateTime($time, $locale, $timezone, $dateType, $timeType);
    }
}
