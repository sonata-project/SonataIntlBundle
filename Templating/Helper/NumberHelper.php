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
use Sonata\IntlBundle\Locale\LocaleDetectorInterface;

/**
 * NumberHelper displays culture information.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 */
class NumberHelper extends BaseHelper
{
    protected $attributes = array();

    protected $textAttributes = array();

    /**
     * Constructor.
     *
     * @param string                                            $charset        The output charset of the helper
     * @param \Sonata\IntlBundle\Locale\LocaleDetectorInterface $localeDetector
     * @param array                                             $attributes     The default attributes to apply to the NumberFormatter instance
     * @param array                                             $textAttributes The default text attributes to apply to the NumberFormatter instance
     */
    public function __construct($charset, LocaleDetectorInterface $localeDetector, array $attributes = array(), array $textAttributes = array())
    {
        parent::__construct($charset, $localeDetector);

        $this->attributes       = $attributes;
        $this->textAttributes   = $textAttributes;
    }

    /**
     * format a value with its percent representation (0.1 => 10%)
     *
     * @param  float  $number
     * @param  array  $attributes
     * @param  array  $textAttributes
     * @param  null   $locale
     * @return string
     */
    public function formatPercent($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        return $this->format($number, \NumberFormatter::PERCENT, $attributes, $textAttributes, $locale);
    }

    /**
     * format a value with its duration representation
     *
     * @param  float  $number
     * @param  array  $attributes
     * @param  array  $textAttributes
     * @param  null   $locale
     * @return string
     */
    public function formatDuration($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        return $this->format($number, \NumberFormatter::DURATION, $attributes, $textAttributes, $locale);
    }

    /**
     * format a value with its decimal representation
     *
     * @param  float  $number
     * @param  array  $attributes
     * @param  array  $textAttributes
     * @param  null   $locale
     * @return string
     */
    public function formatDecimal($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        return $this->format($number, \NumberFormatter::DECIMAL, $attributes, $textAttributes, $locale);
    }

    /**
     * format a value with its spellout representation (1 => one)
     *
     * @param  float  $number
     * @param  array  $attributes
     * @param  array  $textAttributes
     * @param  null   $locale
     * @return string
     */
    public function formatSpellout($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        return $this->format($number, \NumberFormatter::SPELLOUT, $attributes, $textAttributes, $locale);
    }

    /**
     * format a value with its currency representation (1 => 1 $)
     *
     * @param float $number
     * @param $currency
     * @param  array  $attributes
     * @param  array  $textAttributes
     * @param  null   $locale
     * @return string
     */
    public function formatCurrency($number, $currency, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        $formatter = $this->getFormatter($locale ?: $this->localeDetector->getLocale(), \NumberFormatter::CURRENCY, $attributes, $textAttributes);

        return $this->fixCharset($formatter->formatCurrency($number, $currency));
    }

    /**
     * format a value with its scientific representation (10 => 1E1)
     *
     * @param  float  $number
     * @param  array  $attributes
     * @param  array  $textAttributes
     * @param  null   $locale
     * @return string
     */
    public function formatScientific($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        return $this->format($number, \NumberFormatter::SCIENTIFIC, $attributes, $textAttributes, $locale);
    }

     /**
     * format a value with its ordinal representation
     *
     * @param  float  $number
     * @param  array  $attributes
     * @param  array  $textAttributes
     * @param  null   $locale
     * @return string
     */
    public function formatOrdinal($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        return $this->format($number, \NumberFormatter::ORDINAL, $attributes, $textAttributes, $locale);
    }

    /**
     * format a value with its provided style
     *
     * @param float $number
     * @param integer style
     * @param  array  $attributes
     * @param  array  $textAttributes
     * @param  null   $locale
     * @return string
     */
    public function format($number, $style, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        $formatter = $this->getFormatter($locale ?: $this->localeDetector->getLocale(), $style, $attributes, $textAttributes);

        return $this->fixCharset($formatter->format($number));
    }

    /**
     * @param $culture
     * @param $style
     * @param  array            $attributes
     * @param  array            $textAttributes
     * @return \NumberFormatter
     */
    protected function getFormatter($culture, $style, $attributes = array(), $textAttributes = array())
    {
        $formatter = new \NumberFormatter($culture, $style);

        foreach (array_merge($this->textAttributes, $textAttributes)  as $name => $value) {
            $constantName = strtoupper($name);
            if (!defined('NumberFormatter::'.$constantName)) {
                throw new \InvalidArgumentException("Numberformatter has no text attribute '$name'");
            }

            $formatter->setTextAttribute(constant('NumberFormatter::'.$constantName), $value);
        }

        foreach (array_merge($this->attributes, $attributes) as $name => $value) {
            $constantName = strtoupper($name);
            if (!defined('NumberFormatter::'.$constantName)) {
                throw new \InvalidArgumentException("Numberformatter has no attribute '$name'");
            }

            $formatter->setAttribute(constant('NumberFormatter::'.$constantName), $value);
        }

        return $formatter;
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName()
    {
        return 'sonata_intl_number';
    }
}
