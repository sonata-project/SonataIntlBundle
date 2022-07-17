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

use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Intl\Locales;

/**
 * LocaleHelper displays culture information.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 */
final class LocaleHelper extends BaseHelper implements LocaleHelperInterface
{
    public function country(string $code, ?string $locale = null): string
    {
        return $this->fixCharset(Countries::getName($code, $locale ?? $this->getLocale()));
    }

    public function language(string $code, ?string $locale = null): string
    {
        return $this->fixCharset(Languages::getName($code, $locale ?? $this->getLocale()));
    }

    public function locale(string $code, ?string $locale = null): string
    {
        return $this->fixCharset(Locales::getName($code, $locale ?? $this->getLocale()));
    }
}
