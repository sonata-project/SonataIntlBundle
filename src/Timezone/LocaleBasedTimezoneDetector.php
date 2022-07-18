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

use Sonata\IntlBundle\Locale\LocaleDetectorInterface;

/**
 * Detects timezones based on the detected locale.
 *
 * @author Alexander <iam.asm89@gmail.com>
 *
 * NEXT_MAJOR: remove this class.
 *
 * @deprecated since sonata-project/intl-bundle 2.13, to be removed in version 3.0.
 */
class LocaleBasedTimezoneDetector implements TimezoneDetectorInterface
{
    /**
     * @var LocaleDetectorInterface
     */
    protected $localeDetector;

    /**
     * @var array
     */
    protected $timezoneMap;

    public function __construct(LocaleDetectorInterface $localeDetector, array $timezoneMap = [])
    {
        $this->localeDetector = $localeDetector;
        $this->timezoneMap = $timezoneMap;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimezone()
    {
        $locale = $this->localeDetector->getLocale();

        return $this->timezoneMap[$locale] ?? null;
    }
}
