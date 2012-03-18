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

use Sonata\IntlBundle\Locale\LocaleDetectorInterface;
use Sonata\IntlBundle\Timezone\TimezoneDetectorInterface;

/**
 * DateHelper displays culture information. More information here
 * http://userguide.icu-project.org/formatparse/datetime
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 * @author Alexander <iam.asm89@gmail.com>
 */
class DateTimeHelper extends BaseHelper
{
    protected $timezoneDetector;

    /**
     * @param TimezoneDetectorInterface $timezoneDetector
     * @param string                    $charset
     * @param LocaleDetectorInterface   $localeDetector
     */
    public function __construct(TimezoneDetectorInterface $timezoneDetector, $charset, LocaleDetectorInterface $localeDetector)
    {
        parent::__construct($charset, $localeDetector);

        $this->timezoneDetector = $timezoneDetector;
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
            $locale ?: $this->localeDetector->getLocale(),
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::NONE,
            $timezone ?: $this->timezoneDetector->getTimezone(),
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
            $locale ?: $this->localeDetector->getLocale(),
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::MEDIUM,
            $timezone ?: $this->timezoneDetector->getTimezone(),
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
            $locale ?: $this->localeDetector->getLocale(),
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::MEDIUM,
            $timezone ?: $this->timezoneDetector->getTimezone(),
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
            $locale ?: $this->localeDetector->getLocale(),
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::FULL,
            $timezone ?: $this->timezoneDetector->getTimezone(),
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
        return $this->fixCharset($formatter->format($date->getTimestamp()));
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
        $date->setTimezone(new \DateTimeZone($timezone ?: $this->timezoneDetector->getTimezone()));

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
