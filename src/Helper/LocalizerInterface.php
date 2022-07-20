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

namespace Sonata\IntlBundle\Helper;

/**
 * LocaleHelper displays culture information.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 */
interface LocalizerInterface
{
    public function country(string $code, ?string $locale = null): string;

    public function language(string $code, ?string $locale = null): string;

    public function locale(string $code, ?string $locale = null): string;
}
