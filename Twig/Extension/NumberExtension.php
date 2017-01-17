<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\IntlBundle\Twig\Extension;

use Sonata\IntlBundle\Templating\Helper\NumberHelper;

/**
 * NumberExtension extends Twig with some filters to format numbers according
 * to locale and/or custom options.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
class NumberExtension extends \Twig_Extension
{
    /**
     * @var NumberHelper The instance of the NumberHelper helper
     */
    protected $helper;

    /**
     * @param NumberHelper $helper A NumberHelper helper instance
     */
    public function __construct(NumberHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('number_format_currency', array($this, 'formatCurrency'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('number_format_decimal', array($this, 'formatDecimal'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('number_format_scientific', array($this, 'formatScientific'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('number_format_spellout', array($this, 'formatSpellout'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('number_format_percent', array($this, 'formatPercent'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('number_format_duration', array($this, 'formatDuration'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('number_format_ordinal', array($this, 'formatOrdinal'), array('is_safe' => array('html'))),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonata_intl_number';
    }

    /**
     * Formats a number as currency according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int $number         The number to format
     * @param string           $currency       The currency in which format the number
     * @param array            $attributes     The attributes used by \NumberFormatter
     * @param array            $textAttributes The text attributes used by \NumberFormatter
     * @param array            $symbols        The symbols used by the formatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatCurrency($number, $currency, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        $methodArgs = array_pad(func_get_args(), 6, null);

        list($locale, $symbols) = $this->helper->normalizeMethodSignature($methodArgs[4], $methodArgs[5]);

        return $this->helper->formatCurrency($number, $currency, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number as decimal according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int $number         The number to format
     * @param array            $attributes     The attributes used by \NumberFormatter
     * @param array            $textAttributes The text attributes used by \NumberFormatter
     * @param array            $symbols        The symbols used by the formatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatDecimal($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        $methodArgs = array_pad(func_get_args(), 5, null);

        list($locale, $symbols) = $this->helper->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->helper->formatDecimal($number, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number in scientific notation according to the specified
     * locale and \NumberFormatter attributes.
     *
     * @param string|float|int $number         The number to format
     * @param array            $attributes     The attributes used by \NumberFormatter
     * @param array            $textAttributes The text attributes used by \NumberFormatter
     * @param array            $symbols        The symbols used by the formatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatScientific($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        $methodArgs = array_pad(func_get_args(), 5, null);

        list($locale, $symbols) = $this->helper->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->helper->formatScientific($number, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number as spellout according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int $number         The number to format
     * @param array            $attributes     The attributes used by \NumberFormatter
     * @param array            $textAttributes The text attributes used by \NumberFormatter
     * @param array            $symbols        The symbols used by the formatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatSpellout($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        $methodArgs = array_pad(func_get_args(), 5, null);

        list($locale, $symbols) = $this->helper->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->helper->formatSpellout($number, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number as percent according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int $number         The number to format
     * @param array            $attributes     The attributes used by \NumberFormatter
     * @param array            $textAttributes The text attributes used by \NumberFormatter
     * @param array            $symbols        The symbols used by the formatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatPercent($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        $methodArgs = array_pad(func_get_args(), 5, null);

        list($locale, $symbols) = $this->helper->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->helper->formatPercent($number, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number as duration according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int $number         The number to format
     * @param array            $attributes     The attributes used by \NumberFormatter
     * @param array            $textAttributes The text attributes used by \NumberFormatter
     * @param array            $symbols        The symbols used by the formatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatDuration($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        $methodArgs = array_pad(func_get_args(), 5, null);

        list($locale, $symbols) = $this->helper->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->helper->formatDuration($number, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number as ordinal according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int $number         The number to format
     * @param array            $attributes     The attributes used by \NumberFormatter
     * @param array            $textAttributes The text attributes used by \NumberFormatter
     * @param array            $symbols        The symbols used by the formatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatOrdinal($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        $methodArgs = array_pad(func_get_args(), 5, null);

        list($locale, $symbols) = $this->helper->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->helper->formatOrdinal($number, $attributes, $textAttributes, $symbols, $locale);
    }
}
