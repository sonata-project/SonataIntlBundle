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
    protected $session;


    /**
     * Constructor.
     *
     * @param Session $session A Session instance
     * @param array $attributes The default attributes to apply to the NumberFormatter instance
     * @param array $textAttributes The default text attributes to apply to the NumberFormatter instance
     */
    public function __construct(Session $session)
    {
        $this->session          = $session;
    }

    public function formatDate($date, $locale = null)
    {
        $formatter = new \IntlDateFormatter(
            $locale ?: $this->session->getLocale() ,
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::NONE
        );

        return $this->fixCharset($formatter->format($this->getTimestamp($date)));
    }

    public function formatDateTime($datetime, $locale = null)
    {
        $formatter = new \IntlDateFormatter(
            $locale ?: $this->session->getLocale() ,
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::MEDIUM
        );

        return $this->fixCharset($formatter->format($this->getTimestamp($datetime)));
    }

    public function formatTime($time, $locale = null)
    {
        $formatter = new \IntlDateFormatter(
            $locale ?: $this->session->getLocale() ,
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::MEDIUM
        );

        return $this->fixCharset($formatter->format($this->getTimestamp($time)));
    }

    public function format($datetime, $pattern, $locale = null)
    {
        $formatter = new \IntlDateFormatter(
            $locale ?: $this->session->getLocale() ,
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::FULL,
            $datetime instanceof DateTime ? $datetime->getTimeZone()->getName() : null,
            \IntlDateFormatter::GREGORIAN,
            $pattern
        );

        return $this->fixCharset($formatter->format($this->getTimestamp($datetime)));
    }

    public function getTimestamp($data)
    {
        if($data instanceof \DateTime) {
            $data = $data->format('U');
        }

        // the format method accept array or integer
        if(is_numeric($data)) {
            return (int)$data;
        }

        return $data;
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
