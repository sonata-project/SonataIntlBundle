<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\IntlBundle\Timezone;

use Sonata\IntlBundle\Locale\LocaleDetectorInterface;

/**
 * Detects timezones based on the detected locale.
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
class LocaleBasedTimezoneDetector implements TimezoneDetectorInterface, LocaleBasedTimezoneDetectorInterface
{
    /**
     * @var LocaleDetectorInterface
     */
    protected $localeDetector;

    /**
     * @var array
     */
    protected $timezoneMap;

    /**
     * @var string
     */
    protected $defaultTimezone;

    /**
     * @var string
     */
    protected $locale;

    /**
     * Constructor
     *
     * @param LocaleDetectorInterface $localeDetector
     * @param string                  $defaultTimezone
     * @param array                   $timezoneMap
     */
    public function __construct(LocaleDetectorInterface $localeDetector, $defaultTimezone, array $timezoneMap = array())
    {
        $this->localeDetector  = $localeDetector;
        $this->defaultTimezone = $defaultTimezone;
        $this->timezoneMap     = $timezoneMap;
    }

    /**
     * Set the locale used to detect the timezone
     *
     * @param string $locale
     *
     * @return LocaleBasedTimezoneDetector
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get the appropriate timezone.
     *
     * @return string
     */
    public function getTimezone()
    {
        $locale = $this->locale ?: $this->localeDetector->getLocale();

        return isset($this->timezoneMap[$locale]) ? $this->timezoneMap[$locale] : $this->defaultTimezone;
    }
}
