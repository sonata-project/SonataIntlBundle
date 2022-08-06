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

use Symfony\Contracts\Translation\LocaleAwareInterface;

/**
 * Detects timezones based on the detected locale.
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
final class LocaleAwareBasedTimezoneDetector implements TimezoneDetectorInterface, LocaleAwareInterface
{
    private ?string $locale = null;

    /**
     * @param array<string, string> $timezoneMap
     */
    public function __construct(private array $timezoneMap = [])
    {
    }

    public function getTimezone(): ?string
    {
        if (null === $this->locale) {
            return null;
        }

        return $this->timezoneMap[$this->locale] ?? null;
    }

    public function getLocale(): string
    {
        if (null === $this->locale) {
            throw new \LogicException('No locale was set');
        }

        return $this->locale;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }
}
