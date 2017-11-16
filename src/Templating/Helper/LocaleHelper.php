<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\IntlBundle\Templating\Helper;

use Symfony\Component\Intl\Intl;

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
        $name = Intl::getRegionBundle()->getCountryName($code, $locale ?: $this->localeDetector->getLocale());

        return $name ? $this->fixCharset($name) : '';
    }

    /**
     * @param string      $code
     * @param string|null $locale
     *
     * @return string
     */
    public function language($code, $locale = null)
    {
        $codes = explode('_', $code);

        $name = Intl::getLanguageBundle()->getLanguageName(
            $codes[0],
            isset($codes[1]) ? $codes[1] : null,
            $locale ?: $this->localeDetector->getLocale()
        );

        return $name ? $this->fixCharset($name) : '';
    }

    /**
     * @param string      $code
     * @param string|null $locale
     *
     * @return string
     */
    public function locale($code, $locale = null)
    {
        $name = Intl::getLocaleBundle()->getLocaleName($code, $locale ?: $this->localeDetector->getLocale());

        return $name ? $this->fixCharset($name) : '';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonata_intl_locale';
    }
}
