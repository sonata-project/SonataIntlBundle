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

namespace Sonata\IntlBundle\Twig;

use Sonata\IntlBundle\Helper\LocaleHelper;
use Sonata\IntlBundle\Templating\Helper\LocaleHelper as TemplatingLocaleHelper;
use Twig\Extension\RuntimeExtensionInterface;
use TypeError;

final class LocaleRuntime implements RuntimeExtensionInterface
{
    /**
     * @var LocaleHelper|TemplatingLocaleHelper
     */
    private $helper;

    /**
     * @param LocaleHelper|TemplatingLocaleHelper $helper
     */
    public function __construct(object $helper)
    {
        if ($helper instanceof TemplatingLocaleHelper) {
            @trigger_error(
                sprintf('The use of %s is deprecated since 2.13, use %s instead.',TemplatingLocaleHelper::class, LocaleHelper::class),
                \E_USER_DEPRECATED
            );
        } elseif (!$helper instanceof LocaleHelper) {
            throw new TypeError(sprintf('Helper must be an instanceof %s, instanceof %s given', LocaleHelper::class, get_class($helper)));
        }
        $this->helper = $helper;
    }

    /**
     * Returns the localized country name from the provided code.
     *
     * @param string      $code
     * @param string|null $locale
     *
     * @return string
     */
    public function country($code, $locale = null)
    {
        return $this->helper->country($code, $locale);
    }

    /**
     * Returns the localized locale name from the provided code.
     *
     * @param string      $code
     * @param string|null $locale
     *
     * @return string
     */
    public function locale($code, $locale = null)
    {
        return $this->helper->locale($code, $locale);
    }

    /**
     * Returns the localized language name from the provided code.
     *
     * @param string      $code
     * @param string|null $locale
     *
     * @return string
     */
    public function language($code, $locale = null)
    {
        return $this->helper->language($code, $locale);
    }
}
