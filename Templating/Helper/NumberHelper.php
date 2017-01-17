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

use Sonata\IntlBundle\Locale\LocaleDetectorInterface;

/**
 * NumberHelper displays culture information.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
class NumberHelper extends BaseHelper
{
    /**
     * @var array The default attributes to apply to the \NumberFormatter instance
     */
    protected $attributes = array();

    /**
     * @var array The default text attributes to apply to the \NumberFormatter instance
     */
    protected $textAttributes = array();

    /**
     * @var array The symbols used by \NumberFormatter
     */
    protected $symbols = array();

    /**
     * @param string                  $charset        The output charset of the helper
     * @param LocaleDetectorInterface $localeDetector A locale detector instance
     * @param array                   $attributes     The default attributes to apply to the \NumberFormatter instance
     * @param array                   $textAttributes The default text attributes to apply to the \NumberFormatter instance
     * @param array                   $symbols        The default symbols to apply to the \NumberFormatter instance
     */
    public function __construct($charset, LocaleDetectorInterface $localeDetector, array $attributes = array(), array $textAttributes = array(), array $symbols = array())
    {
        parent::__construct($charset, $localeDetector);

        $this->attributes = $attributes;
        $this->textAttributes = $textAttributes;
        $this->symbols = $symbols;
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

        list($locale, $symbols) = $this->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->format($number, \NumberFormatter::PERCENT, $attributes, $textAttributes, $symbols, $locale);
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

        list($locale, $symbols) = $this->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->format($number, \NumberFormatter::DURATION, $attributes, $textAttributes, $symbols, $locale);
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

        list($locale, $symbols) = $this->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->format($number, \NumberFormatter::DECIMAL, $attributes, $textAttributes, $symbols, $locale);
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

        list($locale, $symbols) = $this->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->format($number, \NumberFormatter::SPELLOUT, $attributes, $textAttributes, $symbols, $locale);
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

        list($locale, $symbols) = $this->normalizeMethodSignature($methodArgs[4], $methodArgs[5]);

        $formatter = $this->getFormatter($locale ?: $this->localeDetector->getLocale(), \NumberFormatter::CURRENCY, $attributes, $textAttributes, $symbols);

        return $this->fixCharset($formatter->formatCurrency($number, $currency));
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

        list($locale, $symbols) = $this->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->format($number, \NumberFormatter::SCIENTIFIC, $attributes, $textAttributes, $symbols, $locale);
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

        list($locale, $symbols) = $this->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        return $this->format($number, \NumberFormatter::ORDINAL, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number according to the specified locale and \NumberFormatter
     * attributes.
     *
     * @param string|float|int $number         The number to format
     * @param                  $style
     * @param array            $attributes     The attributes used by the formatter
     * @param array            $textAttributes The text attributes used by the formatter
     * @param array            $symbols        The symbols used by the formatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string
     */
    public function format($number, $style, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        $methodArgs = array_pad(func_get_args(), 6, null);

        list($locale, $symbols) = $this->normalizeMethodSignature($methodArgs[4], $methodArgs[5]);

        $formatter = $this->getFormatter($locale ?: $this->localeDetector->getLocale(), $style, $attributes, $textAttributes, $symbols);

        return $this->fixCharset($formatter->format($number));
    }

    /**
     * Normalizes the given arguments according to the new function signature.
     * It asserts if neither the new nor old signature matches. This function
     * is public just to prevent code duplication inside the Twig Extension.
     *
     * @param mixed $symbols The symbols used by the formatter
     * @param mixed $locale  The locale
     *
     * @return array Arguments list normalized to the new method signature
     *
     * @throws \BadMethodCallException If the arguments does not match any signature
     *
     * @internal
     */
    public function normalizeMethodSignature($symbols, $locale)
    {
        $oldSignature = (is_null($symbols) || is_string($symbols)) && is_null($locale);
        $newSignature = is_array($symbols) && (is_string($locale) || is_null($locale));

        // Confirm possible signatures
        if (!$oldSignature && !$newSignature) {
            throw new \BadMethodCallException('Neither new nor old signature matches, please provide the correct arguments');
        }

        if ($oldSignature) {
            // If the old signature matches, we pass an empty array as symbols
            // argument and the symbols value as the locale argument.
            return array($symbols, array());
        }

        return array($locale, $symbols);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonata_intl_number';
    }

    /**
     * Gets an instance of \NumberFormatter set with the given attributes and
     * style.
     *
     * @param string $culture        The culture used by \NumberFormatter
     * @param string $style          The style used by \NumberFormatter
     * @param array  $attributes     The attributes used by \NumberFormatter
     * @param array  $textAttributes The text attributes used by \NumberFormatter
     * @param array  $symbols        The symbols used by \NumberFormatter
     *
     * @return \NumberFormatter
     */
    protected function getFormatter($culture, $style, $attributes = array(), $textAttributes = array(), $symbols = array())
    {
        $attributes = $this->parseAttributes(array_merge($this->attributes, $attributes));
        $textAttributes = $this->parseAttributes(array_merge($this->textAttributes, $textAttributes));
        $symbols = $this->parseAttributes(array_merge($this->symbols, $symbols));
        $formatter = new \NumberFormatter($culture, $style);

        self::checkInternalClass($formatter, '\NumberFormatter', array(
            'culture' => $culture,
            'style' => $style,
        ));

        foreach ($attributes as $attribute => $value) {
            $formatter->setAttribute($attribute, $value);
        }

        foreach ($textAttributes as $attribute => $value) {
            $formatter->setTextAttribute($attribute, $value);
        }

        foreach ($symbols as $attribute => $value) {
            $formatter->setSymbol($attribute, $value);
        }

        return $formatter;
    }

    /**
     * Converts keys of attributes array to values of \NumberFormatter constants.
     *
     * @param array $attributes The list of attributes
     *
     * @return array List of \NumberFormatter constants
     *
     * @throws \InvalidArgumentException If any attribute does not match any constant
     */
    protected function parseAttributes(array $attributes)
    {
        $result = array();

        foreach ($attributes as $attribute => $value) {
            $result[$this->parseConstantValue($attribute)] = $value;
        }

        return $result;
    }

    /**
     * Parse the given value trying to get a match with a \NumberFormatter constant.
     *
     * @param string $attribute The constant's name
     *
     * @return mixed The \NumberFormatter constant
     *
     * @throws \InvalidArgumentException If the value does not match any constant
     */
    protected function parseConstantValue($attribute)
    {
        $attribute = strtoupper($attribute);
        $constantName = 'NumberFormatter::'.$attribute;

        if (!defined($constantName)) {
            throw new \InvalidArgumentException(sprintf('NumberFormatter has no constant "%s".', $attribute));
        }

        return constant($constantName);
    }
}
