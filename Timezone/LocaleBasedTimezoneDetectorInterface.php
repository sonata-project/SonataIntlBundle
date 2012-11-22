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
 * Interface for TimezoneDetector that use the locale
 */
interface LocaleBasedTimezoneDetectorInterface
{
    /**
     * Set the locale to use to detect the timezone
     *
     * @param string $locale
     *
     * @return LocaleBasedTimezoneDetectorInterface
     */
    public function setLocale($locale);
}
