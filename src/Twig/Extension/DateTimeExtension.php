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

use Sonata\IntlBundle\Helper\DateTimeHelper;
use Sonata\IntlBundle\Templating\Helper\DateTimeHelper as TemplatingDateTimeHelper;
use Sonata\IntlBundle\Twig\DateTimeRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * DateTimeExtension extends Twig with localized date/time capabilities.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 */
class DateTimeExtension extends AbstractExtension
{
    /**
     * @var DateTimeHelper|TemplatingDateTimeHelper
     */
    protected $helper;

    private DateTimeRuntime $dateTimeRuntime;

    /**
     * NEXT_MAJOR: Remove this constructor.
     *
     * @param DateTimeHelper|TemplatingDateTimeHelper $helper
     */
    public function __construct(object $helper)
    {
        if ($helper instanceof TemplatingDateTimeHelper) {
            @trigger_error(
                sprintf('The use of %s is deprecated since 2.13, use %s instead.', TemplatingDateTimeHelper::class, DateTimeHelper::class),
                \E_USER_DEPRECATED
            );
        } elseif (!$helper instanceof DateTimeHelper) {
            throw new \TypeError(sprintf('Helper must be an instanceof %s, instanceof %s given', DateTimeHelper::class, \get_class($helper)));
        }
        $this->helper = $helper;
        $this->dateTimeRuntime = new DateTimeRuntime($helper);
    }

    /**
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('format_date', [$this, 'formatDate'], ['is_safe' => ['html']]), // NEXT_MAJOR: Remove this line
            new TwigFilter('sonata_format_date', [DateTimeRuntime::class, 'formatDate'], ['is_safe' => ['html']]),
            new TwigFilter('format_time', [$this, 'formatTime'], ['is_safe' => ['html']]), // NEXT_MAJOR: Remove this line
            new TwigFilter('sonata_format_time', [DateTimeRuntime::class, 'formatTime'], ['is_safe' => ['html']]),
            new TwigFilter('format_datetime', [$this, 'formatDatetime'], ['is_safe' => ['html']]), // NEXT_MAJOR: Remove this line
            new TwigFilter('sonata_format_datetime', [DateTimeRuntime::class, 'formatDatetime'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * NEXT_MAJOR: Remove this method.
     *
     * @param \DateTime|string|int $date
     * @param string|null          $pattern
     * @param string|null          $locale
     * @param string|null          $timezone
     * @param int|null             $dateType
     *
     * @return string
     */
    public function formatDate($date, $pattern = null, $locale = null, $timezone = null, $dateType = null)
    {
        @trigger_error(
            'The format_date filter is deprecated since 2.12 and will be removed on 3.0. '.
            'Use sonata_format_date instead.',
            \E_USER_DEPRECATED
        );

        return $this->dateTimeRuntime->formatDate($date, $pattern, $locale, $timezone, $dateType);
    }

    /**
     * NEXT_MAJOR: Remove this method.
     *
     * @param \DateTime|string|int $time
     * @param string|null          $pattern
     * @param string|null          $locale
     * @param string|null          $timezone
     * @param int|null             $timeType
     *
     * @return string
     */
    public function formatTime($time, $pattern = null, $locale = null, $timezone = null, $timeType = null)
    {
        @trigger_error(
            'The format_time filter is deprecated since 2.12 and will be removed on 3.0. '.
            'Use sonata_format_time instead.',
            \E_USER_DEPRECATED
        );

        return $this->dateTimeRuntime->formatTime($time, $pattern, $locale, $timezone, $timeType);
    }

    /**
     * NEXT_MAJOR: Remove this method.
     *
     * @param \DateTime|string|int $time
     * @param string|null          $pattern
     * @param string|null          $locale
     * @param string|null          $timezone
     * @param int|null             $dateType
     * @param int|null             $timeType
     *
     * @return string
     */
    public function formatDatetime($time, $pattern = null, $locale = null, $timezone = null, $dateType = null, $timeType = null)
    {
        @trigger_error(
            'The format_date_time filter is deprecated since 2.12 and will be removed on 3.0. '.
            'Use sonata_format_date_time instead.',
            \E_USER_DEPRECATED
        );

        return $this->dateTimeRuntime->formatDatetime($time, $pattern, $locale, $timezone, $timeType);
    }

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since sonata-project/intl-bundle 2.8, to be removed in version 3.0.
     */
    public function getName()
    {
        return 'sonata_intl_datetime';
    }
}
