<?php

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
 * Interfaces for services that are able to detect a timezone.
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
interface TimezoneDetectorInterface
{
    /**
     * Get the appropriate timezone.
     *
     * @return string
     */
    public function getTimezone();
}
