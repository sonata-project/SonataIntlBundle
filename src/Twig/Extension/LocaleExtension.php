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

namespace Sonata\IntlBundle\Twig\Extension;

use Sonata\IntlBundle\Templating\Helper\LocaleHelper;
use Sonata\IntlBundle\Twig\LocaleRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * LocaleExtension extends Twig with local capabilities.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 */
class LocaleExtension extends AbstractExtension
{
    /**
     * @var LocaleHelper
     */
    protected $helper;

    /**
     * @var LocaleRuntime
     */
    private $localeRuntime;

    /**
     * NEXT_MAJOR: Remove this constructor.
     */
    public function __construct(LocaleHelper $helper)
    {
        $this->helper = $helper;
        $this->localeRuntime = new LocaleRuntime($this->helper);
    }

    /**
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('country', [$this, 'country'], ['is_safe' => ['html']]), // NEXT_MAJOR: Remove this line
            new TwigFilter('sonata_country', [$this, 'country'], ['is_safe' => ['html']]),
            new TwigFilter('locale', [$this, 'locale'], ['is_safe' => ['html']]), // NEXT_MAJOR: Remove this line
            new TwigFilter('sonata_locale', [$this, 'locale'], ['is_safe' => ['html']]),
            new TwigFilter('language', [$this, 'language'], ['is_safe' => ['html']]), // NEXT_MAJOR: Remove this line
            new TwigFilter('sonata_language', [$this, 'language'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * NEXT_MAJOR: Remove this method.
     *
     * Returns the localized country name from the provided code.
     *
     * @param string      $code
     * @param string|null $locale
     *
     * @return string
     */
    public function country($code, $locale = null)
    {
        @trigger_error(sprintf(
            'The %s method is deprecated since 2.x and will be removed on 3.0. '.
            'Use %s::%s instead.',
            __METHOD__,
            LocaleRuntime::class,
            __METHOD__,
        ), \E_USER_DEPRECATED);

        return $this->localeRuntime->country($code, $locale);
    }

    /**
     * NEXT_MAJOR: Remove this method.
     *
     * Returns the localized locale name from the provided code.
     *
     * @param string      $code
     * @param string|null $locale
     *
     * @return string
     */
    public function locale($code, $locale = null)
    {
        @trigger_error(sprintf(
            'The %s method is deprecated since 2.x and will be removed on 3.0. '.
            'Use %s::%s instead.',
            __METHOD__,
            LocaleRuntime::class,
            __METHOD__,
        ), \E_USER_DEPRECATED);

        return $this->localeRuntime->locale($code, $locale);
    }

    /**
     * NEXT_MAJOR: Remove this method.
     *
     * Returns the localized language name from the provided code.
     *
     * @param string      $code
     * @param string|null $locale
     *
     * @return string
     */
    public function language($code, $locale = null)
    {
        @trigger_error(sprintf(
            'The %s method is deprecated since 2.x and will be removed on 3.0. '.
            'Use %s::%s instead.',
            __METHOD__,
            LocaleRuntime::class,
            __METHOD__,
        ), \E_USER_DEPRECATED);

        return $this->localeRuntime->language($code, $locale);
    }

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since sonata-project/intl-bundle 2.8, to be removed in version 3.0.
     */
    public function getName()
    {
        return 'sonata_intl_locale';
    }
}
