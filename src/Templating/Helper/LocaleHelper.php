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

namespace Sonata\IntlBundle\Templating\Helper;

use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Intl\Locales;

/**
 * LocaleHelper displays culture information.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 */
class LocaleHelper extends BaseHelper
{
    /**
     * @param string      $code
     * @param string|null $locale
     *
     * @return string
     */
    public function country($code, $locale = null)
    {
        // NEXT_MAJOR: Remove this when dropping < 4.3 Symfony support
        if (!class_exists(Countries::class)) {
            $name = Intl::getRegionBundle()->getCountryName($code, $locale ?: $this->localeDetector->getLocale());

            return $name ? $this->fixCharset($name) : '';
        }

        return $this->fixCharset(Countries::getName($code, $locale ?: $this->localeDetector->getLocale()));
    }

    /**
     * @param string      $code
     * @param string|null $locale
     *
     * @return string
     */
    public function language($code, $locale = null)
    {
        // NEXT_MAJOR: Remove this when dropping < 4.3 Symfony support
        if (!class_exists(Languages::class)) {
            $codes = explode('_', $code);

            $name = Intl::getLanguageBundle()->getLanguageName(
                $codes[0],
                $codes[1] ?? null,
                $locale ?: $this->localeDetector->getLocale()
            );

            return $name ? $this->fixCharset($name) : '';
        }

        return $this->fixCharset(Languages::getName($code, $locale ?: $this->localeDetector->getLocale()));
    }

    /**
     * @param string      $code
     * @param string|null $locale
     *
     * @return string
     */
    public function locale($code, $locale = null)
    {
        // NEXT_MAJOR: Remove this when dropping < 4.3 Symfony support
        if (!class_exists(Locales::class)) {
            $name = Intl::getLocaleBundle()->getLocaleName($code, $locale ?: $this->localeDetector->getLocale());

            return $name ? $this->fixCharset($name) : '';
        }

        return $this->fixCharset(Locales::getName($code, $locale ?: $this->localeDetector->getLocale()));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonata_intl_locale';
    }
}
