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

/**
 * Detects timezone based on other detectors.
 *
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
class ChainTimezoneDetector implements TimezoneDetectorInterface
{
    /**
     * @var TimezoneDetectorInterface[]
     */
    protected $timezoneDetectors;

    /**
     * @var string
     */
    protected $defaultTimezone;

    /**
     * @var string|null
     */
    protected $guessedTimezone;

    /**
     * @param string $defaultTimezone
     */
    public function __construct($defaultTimezone)
    {
        $this->defaultTimezone = $defaultTimezone;
        $this->timezoneDetectors = array();
    }

    /**
     * @param TimezoneDetectorInterface $timezoneDetector
     */
    public function addDetector(TimezoneDetectorInterface $timezoneDetector)
    {
        $this->timezoneDetectors[] = $timezoneDetector;
    }

    /**
     * {@inheritDoc}
     */
    public function getTimezone()
    {
        if (!$this->guessedTimezone) {
            $availableTimezones = \DateTimeZone::listIdentifiers();

            foreach ($this->timezoneDetectors as $timezoneDetector) {
                if ($timezone = $timezoneDetector->getTimezone()) {
                    if (in_array($timezone, $availableTimezones)) {
                        return $this->guessedTimezone = $timezone;
                    }
                }
            }

            $this->guessedTimezone = $this->defaultTimezone;
        }

        return $this->guessedTimezone;
    }
}
