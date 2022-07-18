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

namespace Sonata\IntlBundle\Locale;

/**
 * NEXT_MAJOR: remove this interface.
 *
 * @deprecated since sonata-project/intl-bundle 2.13, to be removed in version 3.0.
 */
interface LocaleDetectorInterface
{
    /**
     * @return string
     */
    public function getLocale();
}
