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

namespace Sonata\IntlBundle\Helper;

/**
 * DateHelper displays culture information. More information here
 * http://userguide.icu-project.org/formatparse/datetime.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 * @author Alexander <iam.asm89@gmail.com>
 */
interface DateTimeFormatterInterface
{
    /**
     * @param int|null $dateType See \IntlDateFormatter::getDateType
     */
    public function formatDate(
        \DateTimeInterface|string|int $date,
        ?string $locale = null,
        ?string $timezone = null,
        ?int $dateType = null
    ): string;

    /**
     * @param int|null $dateType See \IntlDateFormatter::getDateType
     * @param int|null $timeType See \IntlDateFormatter::getTimeType
     */
    public function formatDateTime(
        \DateTimeInterface|string|int $datetime,
        ?string $locale = null,
        ?string $timezone = null,
        ?int $dateType = null,
        ?int $timeType = null
    ): string;

    /**
     * @param int|null $timeType See \IntlDateFormatter::getTimeType
     */
    public function formatTime(
        \DateTimeInterface|string|int $time,
        ?string $locale = null,
        ?string $timezone = null,
        ?int $timeType = null
    ): string;

    public function format(
        \DateTimeInterface|string|int $datetime,
        string $pattern,
        ?string $locale = null,
        ?string $timezone = null
    ): string;

    /**
     * Gets a date time instance by a given data and timezone.
     */
    public function getDatetime(
        \DateTimeInterface|string|int $data,
        ?string $timezone = null
    ): \DateTimeInterface;
}
