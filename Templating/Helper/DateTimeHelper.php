<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\IntlBundle\Templating\Helper;

use Symfony\Component\HttpFoundation\Request;

/**
 * DateHelper displays culture information. More information here
 * http://userguide.icu-project.org/formatparse/datetime
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 */
class DateTimeHelper extends BaseHelper
{
    protected $defaultTimezone;

    /**
     * @param \DateTimeZone $defaultTimezone
     * @param $charset
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function __construct(\DateTimeZone $defaultTimezone, $charset, Request $request)
    {
        parent::__construct($charset, $request);

        $this->defaultTimezone = $defaultTimezone;
    }

    /**
     * @param \Datetime|string|integer $date
     * @param null|string $locale
     * @param null|string timezone
     * @return string
     */
    public function formatDate($date, $locale = null, $timezone = null)
    {
        $date = $this->getDatetime($date, $timezone);

        $formatter = new \IntlDateFormatter(
            $locale ?: $this->request->getLocale() ,
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::NONE,
            $timezone ?: $date->getTimezone()->getName(),
            \IntlDateFormatter::GREGORIAN
        );

        return $this->process($formatter, $date);
    }

    /**
     * @param \Datetime|string|integer $datetime
     * @param null|string $locale
     * @param null|string timezone
     * @return string
     */
    public function formatDateTime($datetime, $locale = null, $timezone = null)
    {
        $date = $this->getDatetime($datetime, $timezone);

        $formatter = new \IntlDateFormatter(
            $locale ?: $this->request->getLocale() ,
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::MEDIUM,
            $timezone ?: $date->getTimezone()->getName(),
            \IntlDateFormatter::GREGORIAN
        );

        return $this->process($formatter, $date);
    }

    /**
     * @param \Datetime|string|integer $time
     * @param null|string $locale
     * @param null|string timezone
     * @return string
     */
    public function formatTime($time, $locale = null, $timezone = null)
    {
        $date = $this->getDatetime($time, $timezone);

        $formatter = new \IntlDateFormatter(
            $locale ?: $this->request->getLocale() ,
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::MEDIUM,
            $timezone ?: $date->getTimezone()->getName(),
            \IntlDateFormatter::GREGORIAN
        );

        return $this->process($formatter, $date);
    }

    /**
     * @param \Datetime|string|integer $datetime
     * @param $pattern
     * @param null|string $locale
     * @param null|string timezone
     * @return string
     */
    public function format($datetime, $pattern, $locale = null, $timezone = null)
    {
        $date = $this->getDatetime($datetime, $timezone);

        $formatter = new \IntlDateFormatter(
            $locale ?: $this->request->getLocale() ,
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::FULL,
            $timezone ?: $date->getTimezone()->getName(),
            \IntlDateFormatter::GREGORIAN,
            $pattern
        );

        return $this->process($formatter, $date);
    }

    /**
     * @param \IntlDateFormatter $formatter
     * @param \Datetime $date
     * @return string
     */
    public function process(\IntlDateFormatter $formatter, \Datetime $date)
    {
        $time = $date->getTimestamp();
        return $this->fixCharset($formatter->format($time));
    }

    /**
     * @param \Datetime|string|integer $data
     * @param null|string timezone
     * @return \Datetime
     */
    public function getDatetime($data, $timezone = null)
    {
        if($data instanceof \DateTime) {
            return $data;
        }

        // the format method accept array or integer
        if (is_numeric($data)) {
             $data = (int)$data;
        }

        if (is_string($data)) {
            $data = strtotime($data);
        }

        $date = new \DateTime();
        $date->setTimestamp($data);
        $date->setTimezone($timezone ?: $this->defaultTimezone);

        return $date;
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName()
    {
        return 'sonata_intl_datetime';
    }
}
