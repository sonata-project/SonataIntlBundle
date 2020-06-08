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

use Sonata\IntlBundle\Locale\LocaleDetectorInterface;
use Twig\Extra\Intl\IntlExtension;

/**
 * NumberHelper displays culture information.
 *
 * @final since sonata-project/intl-bundle 2.x
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
class NumberHelper extends BaseHelper
{
    /**
     * @var array The default attributes to apply to the \NumberFormatter instance
     */
    protected $attributes = [];

    /**
     * @var array The default text attributes to apply to the \NumberFormatter instance
     */
    protected $textAttributes = [];

    /**
     * @var array The symbols used by \NumberFormatter
     */
    protected $symbols = [];

    /**
     * @var IntlExtension|null
     */
    private $intlExtension;

    /**
     * @param string                  $charset        The output charset of the helper
     * @param LocaleDetectorInterface $localeDetector A locale detector instance
     * @param array                   $attributes     The default attributes to apply to the \NumberFormatter instance
     * @param array                   $textAttributes The default text attributes to apply to the \NumberFormatter instance
     * @param array                   $symbols        The default symbols to apply to the \NumberFormatter instance
     */
    public function __construct($charset, LocaleDetectorInterface $localeDetector, array $attributes = [], array $textAttributes = [], array $symbols = [], ?IntlExtension $intlExtension = null)
    {
        parent::__construct($charset, $localeDetector);

        $this->attributes = $attributes;
        $this->textAttributes = $textAttributes;
        $this->symbols = $symbols;
        $this->intlExtension = $intlExtension;
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

        [$locale, $symbols] = $this->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        if ($this->intlExtension) {
            $attributes = self::processLegacyAttributes($attributes);
            $intlExtension = $this->getIntlExtension($locale, \NumberFormatter::PERCENT, $textAttributes);

            return $this->fixCharset($intlExtension->formatNumberStyle('percent', $number, $attributes, 'default', $locale ?: $this->localeDetector->getLocale()));
        }

        // NEXT_MAJOR: Execute the previous block unconditionally and remove following lines in this method.

        @trigger_error(sprintf(
            'Not passing an instance of "%s" as argument 6 for %s::__construct() is deprecated since sonata-project/intl-bundle 2.x.'
            .' and will throw an exception in version 3.x.',
            IntlExtension::class,
            __CLASS__
        ));

        return $this->format($number, \NumberFormatter::PERCENT, $attributes, $textAttributes, $symbols, $locale);
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

        [$locale, $symbols] = $this->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        if ($this->intlExtension) {
            $attributes = self::processLegacyAttributes($attributes);
            $intlExtension = $this->getIntlExtension($locale, \NumberFormatter::DURATION, $textAttributes);

            return $this->fixCharset($intlExtension->formatNumberStyle('duration', $number, $attributes, 'default', $locale ?: $this->localeDetector->getLocale()));
        }

        // NEXT_MAJOR: Execute the previous block unconditionally and remove following lines in this method.

        @trigger_error(sprintf(
            'Not passing an instance of "%s" as argument 6 for %s::__construct() is deprecated since sonata-project/intl-bundle 2.x.'
            .' and will throw an exception in version 3.x.',
            IntlExtension::class,
            __CLASS__
        ));

        return $this->format($number, \NumberFormatter::DURATION, $attributes, $textAttributes, $symbols, $locale);
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

        [$locale, $symbols] = $this->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        if ($this->intlExtension) {
            $attributes = self::processLegacyAttributes($attributes);
            $intlExtension = $this->getIntlExtension($locale, \NumberFormatter::DECIMAL, $textAttributes);

            return $this->fixCharset($intlExtension->formatNumberStyle('decimal', $number, $attributes, 'default', $locale ?: $this->localeDetector->getLocale()));
        }

        // NEXT_MAJOR: Execute the previous block unconditionally and remove following lines in this method.

        @trigger_error(sprintf(
            'Not passing an instance of "%s" as argument 6 for %s::__construct() is deprecated since sonata-project/intl-bundle 2.x.'
            .' and will throw an exception in version 3.x.',
            IntlExtension::class,
            __CLASS__
        ));

        return $this->format($number, \NumberFormatter::DECIMAL, $attributes, $textAttributes, $symbols, $locale);
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

        [$locale, $symbols] = $this->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        if ($this->intlExtension) {
            $attributes = self::processLegacyAttributes($attributes);
            $intlExtension = $this->getIntlExtension($locale, \NumberFormatter::SPELLOUT, $textAttributes);

            return $this->fixCharset($intlExtension->formatNumberStyle('spellout', $number, $attributes, 'default', $locale ?: $this->localeDetector->getLocale()));
        }

        // NEXT_MAJOR: Execute the previous block unconditionally and remove following lines in this method.

        @trigger_error(sprintf(
            'Not passing an instance of "%s" as argument 6 for %s::__construct() is deprecated since sonata-project/intl-bundle 2.x.'
            .' and will throw an exception in version 3.x.',
            IntlExtension::class,
            __CLASS__
        ));

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
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatCurrency($number, $currency, array $attributes = [], array $textAttributes = [], $locale = null)
    {
        $methodArgs = array_pad(\func_get_args(), 6, null);

        [$locale, $symbols] = $this->normalizeMethodSignature($methodArgs[4], $methodArgs[5]);

        if ($this->intlExtension) {
            $attributes = self::processLegacyAttributes($attributes);
            $intlExtension = $this->getIntlExtension($locale, \NumberFormatter::CURRENCY, $textAttributes);

            return $this->fixCharset($intlExtension->formatCurrency($number, $currency, $attributes, $locale ?: $this->localeDetector->getLocale()));
        }

        // NEXT_MAJOR: Execute the previous block unconditionally and remove following lines in this method.

        @trigger_error(sprintf(
            'Not passing an instance of "%s" as argument 6 for %s::__construct() is deprecated since sonata-project/intl-bundle 2.x.'
            .' and will throw an exception in version 3.x.',
            IntlExtension::class,
            __CLASS__
        ));

        // convert Doctrine's decimal type (fixed-point number represented as string) to float for backward compatibility
        if (\is_string($number) && is_numeric($number)) {
            $number = (float) $number;
        }

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
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string The formatted number
     */
    public function formatScientific($number, array $attributes = [], array $textAttributes = [], $locale = null)
    {
        $methodArgs = array_pad(\func_get_args(), 5, null);

        [$locale, $symbols] = $this->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        if ($this->intlExtension) {
            $attributes = self::processLegacyAttributes($attributes);
            $intlExtension = $this->getIntlExtension($locale, \NumberFormatter::SCIENTIFIC, $textAttributes);

            return $this->fixCharset($intlExtension->formatNumberStyle('scientific', $number, $attributes, 'default', $locale ?: $this->localeDetector->getLocale()));
        }

        // NEXT_MAJOR: Execute the previous block unconditionally and remove following lines in this method.

        @trigger_error(sprintf(
            'Not passing an instance of "%s" as argument 6 for %s::__construct() is deprecated since sonata-project/intl-bundle 2.x.'
            .' and will throw an exception in version 3.x.',
            IntlExtension::class,
            __CLASS__
        ));

        return $this->format($number, \NumberFormatter::SCIENTIFIC, $attributes, $textAttributes, $symbols, $locale);
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

        [$locale, $symbols] = $this->normalizeMethodSignature($methodArgs[3], $methodArgs[4]);

        if ($this->intlExtension) {
            $attributes = self::processLegacyAttributes($attributes);
            $intlExtension = $this->getIntlExtension($locale, \NumberFormatter::ORDINAL, $textAttributes);

            return $this->fixCharset($intlExtension->formatNumberStyle('ordinal', $number, $attributes, 'default', $locale ?: $this->localeDetector->getLocale()));
        }

        // NEXT_MAJOR: Execute the previous block unconditionally and remove following lines in this method.

        @trigger_error(sprintf(
            'Not passing an instance of "%s" as argument 6 for %s::__construct() is deprecated since sonata-project/intl-bundle 2.x.'
            .' and will throw an exception in version 3.x.',
            IntlExtension::class,
            __CLASS__
        ));

        return $this->format($number, \NumberFormatter::ORDINAL, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number according to the specified locale and \NumberFormatter
     * attributes.
     *
     * @param string|float|int $number         The number to format
     * @param string           $style
     * @param array            $attributes     The attributes used by the formatter
     * @param array            $textAttributes The text attributes used by the formatter
     * @param string|null      $locale         The locale used to format the number
     *
     * @return string
     */
    public function format($number, $style, array $attributes = [], array $textAttributes = [], $locale = null)
    {
        $methodArgs = array_pad(\func_get_args(), 6, null);

        [$locale, $symbols] = $this->normalizeMethodSignature($methodArgs[4], $methodArgs[5]);

        if ($this->intlExtension) {
            $attributes = self::processLegacyAttributes($attributes);
            $intlExtension = $this->getIntlExtension($locale, $style, $textAttributes);

            return $this->fixCharset($intlExtension->formatNumberStyle($style, $number, $attributes, $locale ?: $this->localeDetector->getLocale()));
        }

        // NEXT_MAJOR: Execute the previous block unconditionally and remove following lines in this method.

        @trigger_error(sprintf(
            'Not passing an instance of "%s" as argument 6 for %s::__construct() is deprecated since sonata-project/intl-bundle 2.x.'
            .' and will throw an exception in version 3.x.',
            IntlExtension::class,
            __CLASS__
        ));

        $formatter = $this->getFormatter($locale ?: $this->localeDetector->getLocale(), $style, $attributes, $textAttributes, $symbols);

        return $this->fixCharset($formatter->format($number));
    }

    /**
     * NEXT_MAJOR: Remove this method.
     *
     * Normalizes the given arguments according to the new function signature.
     * It asserts if neither the new nor old signature matches. This function
     * is public just to prevent code duplication inside the Twig Extension.
     *
     * @deprecated since sonata-project/intl-bundle 2.x
     *
     * @param mixed $symbols The symbols used by the formatter
     * @param mixed $locale  The locale
     *
     * @throws \BadMethodCallException If the arguments does not match any signature
     *
     * @return array Arguments list normalized to the new method signature
     *
     * @internal
     */
    public function normalizeMethodSignature($symbols, $locale)
    {
        @trigger_error(sprintf(
            'Method "%s()" is deprecated since sonata-project/intl-bundle 2.x.'
            .' and will be removed in version 3.x.',
            __METHOD__
        ));

        $oldSignature = (null === $symbols || \is_string($symbols)) && null === $locale;
        $newSignature = \is_array($symbols) && (\is_string($locale) || null === $locale);

        // Confirm possible signatures
        if (!$oldSignature && !$newSignature) {
            throw new \BadMethodCallException('Neither new nor old signature matches, please provide the correct arguments');
        }

        if ($oldSignature) {
            // If the old signature matches, we pass an empty array as symbols
            // argument and the symbols value as the locale argument.
            return [$symbols, []];
        }

        return [$locale, $symbols];
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
    protected function getFormatter($culture, $style, $attributes = [], $textAttributes = [], $symbols = [])
    {
        $attributes = $this->parseAttributes(array_merge($this->attributes, $attributes));
        $textAttributes = $this->parseAttributes(array_merge($this->textAttributes, $textAttributes));
        $symbols = $this->parseAttributes(array_merge($this->symbols, $symbols));
        $formatter = new \NumberFormatter($culture, $style);

        self::checkInternalClass($formatter, '\NumberFormatter', [
            'culture' => $culture,
            'style' => $style,
        ]);

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
     * NEXT_MAJOR: Remove this method.
     *
     * Converts keys of attributes array to values of \NumberFormatter constants.
     *
     * @deprecated since sonata-project/intl-bundle 2.x
     *
     * @param array $attributes The list of attributes
     *
     * @throws \InvalidArgumentException If any attribute does not match any constant
     *
     * @return array List of \NumberFormatter constants
     */
    protected function parseAttributes(array $attributes)
    {
        @trigger_error(sprintf(
            'Method "%s()" is deprecated since sonata-project/intl-bundle 2.x.'
            .' and will be removed in version 3.x.',
            __METHOD__
        ));

        $result = [];

        foreach ($attributes as $attribute => $value) {
            $result[$this->parseConstantValue($attribute)] = $value;
        }

        return $result;
    }

    /**
     * NEXT_MAJOR: Remove this method.
     *
     * Parse the given value trying to get a match with a \NumberFormatter constant.
     *
     * @deprecated since sonata-project/intl-bundle 2.x
     *
     * @param string $attribute The constant's name
     *
     * @throws \InvalidArgumentException If the value does not match any constant
     *
     * @return mixed The \NumberFormatter constant
     */
    protected function parseConstantValue($attribute)
    {
        @trigger_error(sprintf(
            'Method "%s()" is deprecated since sonata-project/intl-bundle 2.x.'
            .' and will be removed in version 3.x.',
            __METHOD__
        ));

        $attribute = strtoupper($attribute);
        $constantName = 'NumberFormatter::'.$attribute;

        if (!\defined($constantName)) {
            throw new \InvalidArgumentException(sprintf('NumberFormatter has no constant "%s".', $attribute));
        }

        return \constant($constantName);
    }

    /**
     * NEXT_MAJOR: Remove this method.
     *
     * Replaces legacy attribute names with its new variants.
     */
    private static function processLegacyAttributes(array $attributes): array
    {
        if (isset($attributes['fraction_digits'])) {
            $curatedAttributes['fraction_digit'] = $attributes['fraction_digits'];
            unset($attributes['fraction_digits']);
        }

        return $attributes;
    }

    private function getIntlExtension(?string $locale = null, int $style, array $textAttributes): IntlExtension
    {
        if (empty($textAttributes)) {
            return $this->intlExtension;
        }

        $numberFormatterProto = $this->getFormatter($locale ?: $this->localeDetector->getLocale(), $style, [], $textAttributes);

        return new IntlExtension(null, $numberFormatterProto);
    }
}
