<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\IntlBundle\Templating\Helper;

use Symfony\Component\Locale\Locale;

/**
 * LocaleHelper displays culture information.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 */
class LocaleHelper extends BaseHelper
{
    /**
     * @param $code
     * @param  null   $locale
     * @return string
     */
    public function country($code, $locale = null)
    {
        $countries = Locale::getDisplayCountries($locale ?: $this->localeDetector->getLocale());

        if (array_key_exists($code, $countries)) {
            return $this->fixCharset($countries[$code]);
        }

        return '';
    }

    /**
     * @param $code
     * @param  null   $locale
     * @return string
     */
    public function language($code, $locale = null)
    {
        $languages = Locale::getDisplayLanguages($locale ?: $this->localeDetector->getLocale());

        if (array_key_exists($code, $languages)) {
            return $this->fixCharset($languages[$code]);
        }

        return '';
    }

    /**
     * @param $code
     * @param  null   $locale
     * @return string
     */
    public function locale($code, $locale = null)
    {
        $locales = Locale::getDisplayLocales($locale ?: $this->localeDetector->getLocale());

        if (array_key_exists($code, $locales)) {
            return $this->fixCharset($locales[$code]);
        }

        return '';
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName()
    {
        return 'sonata_intl_locale';
    }
}
