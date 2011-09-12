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

use Symfony\Component\HttpFoundation\Session;

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
     * @param \Symfony\Component\HttpFoundation\Session $session
     */
    public function __construct(\DateTimeZone $defaultTimezone, $charset, Session $session)
    {
        parent::__construct($charset, $session);

        $this->defaultTimezone = $defaultTimezone;
    }

    /**
     * @param \Datetime|string|integer $date
     * @param null $locale
     * @return string
     */
    public function formatDate($date, $locale = null)
    {
        $date = $this->getDatetime($date);

        $formatter = new \IntlDateFormatter(
            $locale ?: $this->session->getLocale() ,
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::NONE,
            $date->getTimezone()->getName(),
            \IntlDateFormatter::GREGORIAN
        );

        return $this->process($formatter, $date);
    }

    /**
     * @param \Datetime|string|integer $datetime
     * @param null $locale
     * @return string
     */
    public function formatDateTime($datetime, $locale = null)
    {
        $date = $this->getDatetime($datetime);

        $formatter = new \IntlDateFormatter(
            $locale ?: $this->session->getLocale() ,
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::MEDIUM,
            $date->getTimezone()->getName(),
            \IntlDateFormatter::GREGORIAN
        );

        return $this->process($formatter, $date);
    }

    /**
     * @param \Datetime|string|integer $time
     * @param null $locale
     * @return string
     */
    public function formatTime($time, $locale = null)
    {
        $date = $this->getDatetime($time);

        $formatter = new \IntlDateFormatter(
            $locale ?: $this->session->getLocale() ,
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::MEDIUM,
            $date->getTimezone()->getName(),
            \IntlDateFormatter::GREGORIAN
        );

        return $this->process($formatter, $date);
    }

    /**
     * @param \Datetime|string|integer $datetime
     * @param $pattern
     * @param null $locale
     * @return string
     */
    public function format($datetime, $pattern, $locale = null)
    {
        $date = $this->getDatetime($datetime);

        $formatter = new \IntlDateFormatter(
            $locale ?: $this->session->getLocale() ,
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::FULL,
            $date->getTimezone()->getName(),
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
        return $this->fixCharset($formatter->format($date));
    }

    /**
     * @param \Datetime|string|integer $data
     * @return \Datetime
     */
    public function getDatetime($data)
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
        $date->setTimezone($this->defaultTimezone);

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
