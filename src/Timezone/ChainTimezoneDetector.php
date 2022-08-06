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

namespace Sonata\IntlBundle\Timezone;

/**
 * Detects timezone based on other detectors.
 *
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
final class ChainTimezoneDetector implements TimezoneDetectorInterface
{
    /**
     * @var TimezoneDetectorInterface[]
     */
    private array $timezoneDetectors = [];

    private ?string $guessedTimezone = null;

    public function __construct(private string $defaultTimezone)
    {
    }

    public function addDetector(TimezoneDetectorInterface $timezoneDetector): void
    {
        $this->timezoneDetectors[] = $timezoneDetector;
    }

    public function getTimezone(): string
    {
        if (null === $this->guessedTimezone) {
            $availableTimezones = \DateTimeZone::listIdentifiers();

            foreach ($this->timezoneDetectors as $timezoneDetector) {
                $timezone = $timezoneDetector->getTimezone();

                if (null !== $timezone && \in_array($timezone, $availableTimezones, true)) {
                    return $this->guessedTimezone = $timezone;
                }
            }

            $this->guessedTimezone = $this->defaultTimezone;
        }

        return $this->guessedTimezone;
    }
}
