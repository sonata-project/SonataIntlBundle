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

use Sonata\IntlBundle\Helper\NumberHelper;
use Sonata\IntlBundle\Templating\Helper\NumberHelper as TemplatingNumberHelper;
use Twig\Extension\RuntimeExtensionInterface;
use TypeError;

final class NumberRuntime implements RuntimeExtensionInterface
{
    /**
     * @var NumberHelper|TemplatingNumberHelper The instance of the NumberHelper helper
     */
    private $helper;

    /**
     * @param NumberHelper|TemplatingNumberHelper $helper A NumberHelper helper instance
     */
    public function __construct(object $helper)
    {
        if ($helper instanceof TemplatingNumberHelper) {
            @trigger_error(
                sprintf('The use of %s is deprecated since 2.13, use %s instead.',TemplatingNumberHelper::class, NumberHelper::class),
                \E_USER_DEPRECATED
            );
        } elseif (!$helper instanceof NumberHelper) {
            throw new TypeError(sprintf('Helper must be an instanceof %s, instanceof %s given', NumberHelper::class, get_class($helper)));
        }
        $this->helper = $helper;
    }

    /**
     * Formats a number as currency according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int $number         The number to format
     * @param string           $currency       The currency in which format the number
     * @param array            $attributes     The attributes used by \NumberFormatter
     * @param array            $textAttributes The text attributes used by \NumberFormatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatCurrency($number, $currency, array $attributes = [], array $textAttributes = [], $locale = null)
    {
        $methodArgs = array_pad(\func_get_args(), 6, null);

        [$locale, $symbols] = $this->helper->normalizeMethodSignature($methodArgs[4], $methodArgs[5]);

        return $this->helper->formatCurrency($number, $currency, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number as decimal according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int $number         The number to format
     * @param array            $attributes     The attributes used by \NumberFormatter
     * @param array            $textAttributes The text attributes used by \NumberFormatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatDecimal($number, array $attributes = [], array $textAttributes = [], $locale = null)
    {
        $methodArgs = array_pad(\func_get_args(), 5, null);

        [$locale, $symbols] = $this->helper->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->helper->formatDecimal($number, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number in scientific notation according to the specified
     * locale and \NumberFormatter attributes.
     *
     * @param string|float|int $number         The number to format
     * @param array            $attributes     The attributes used by \NumberFormatter
     * @param array            $textAttributes The text attributes used by \NumberFormatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatScientific($number, array $attributes = [], array $textAttributes = [], $locale = null)
    {
        $methodArgs = array_pad(\func_get_args(), 5, null);

        [$locale, $symbols] = $this->helper->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->helper->formatScientific($number, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number as spellout according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int $number         The number to format
     * @param array            $attributes     The attributes used by \NumberFormatter
     * @param array            $textAttributes The text attributes used by \NumberFormatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatSpellout($number, array $attributes = [], array $textAttributes = [], $locale = null)
    {
        $methodArgs = array_pad(\func_get_args(), 5, null);

        [$locale, $symbols] = $this->helper->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->helper->formatSpellout($number, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number as percent according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int $number         The number to format
     * @param array            $attributes     The attributes used by \NumberFormatter
     * @param array            $textAttributes The text attributes used by \NumberFormatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatPercent($number, array $attributes = [], array $textAttributes = [], $locale = null)
    {
        $methodArgs = array_pad(\func_get_args(), 5, null);

        [$locale, $symbols] = $this->helper->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->helper->formatPercent($number, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number as duration according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int $number         The number to format
     * @param array            $attributes     The attributes used by \NumberFormatter
     * @param array            $textAttributes The text attributes used by \NumberFormatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatDuration($number, array $attributes = [], array $textAttributes = [], $locale = null)
    {
        $methodArgs = array_pad(\func_get_args(), 5, null);

        [$locale, $symbols] = $this->helper->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->helper->formatDuration($number, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number as ordinal according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int $number         The number to format
     * @param array            $attributes     The attributes used by \NumberFormatter
     * @param array            $textAttributes The text attributes used by \NumberFormatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatOrdinal($number, array $attributes = [], array $textAttributes = [], $locale = null)
    {
        $methodArgs = array_pad(\func_get_args(), 5, null);

        [$locale, $symbols] = $this->helper->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->helper->formatOrdinal($number, $attributes, $textAttributes, $symbols, $locale);
    }
}
