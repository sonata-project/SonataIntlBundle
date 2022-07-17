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
class LocaleAwareBasedTimezoneDetector implements TimezoneDetectorInterface, LocaleAwareInterface
{
    /**
     * @var string
     */
    protected $locale;

    /**
     * @var array
     */
    protected $timezoneMap;

    public function __construct(array $timezoneMap = [])
    {
        $this->timezoneMap = $timezoneMap;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimezone()
    {
        if (null === $this->locale) {
            return null;
        }

        return $this->timezoneMap[$this->locale] ?? null;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale(string $locale)
    {
        $this->locale = $locale;
    }
}
