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

namespace Sonata\IntlBundle\Helper;

/**
 * NumberHelper displays culture information.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
final class NumberFormatter extends BaseHelper implements NumberFormatterInterface
{
    /**
     * @var array<string, int|float> The default attributes to apply to the \NumberFormatter instance
     */
    private array $attributes;

    /**
     * @var array<string, string> The default text attributes to apply to the \NumberFormatter instance
     */
    private array $textAttributes;

    /**
     * @var array<string, string> The symbols used by \NumberFormatter
     */
    private array $symbols;

    /**
     * @param string                   $charset        The output charset of the helper
     * @param array<string, int|float> $attributes     The default attributes to apply to the \NumberFormatter instance
     * @param array<string, string>    $textAttributes The default text attributes to apply to the \NumberFormatter instance
     * @param array<string, string>    $symbols        The default symbols to apply to the \NumberFormatter instance
     */
    public function __construct(string $charset, array $attributes = [], array $textAttributes = [], array $symbols = [])
    {
        parent::__construct($charset);

        $this->attributes = $attributes;
        $this->textAttributes = $textAttributes;
        $this->symbols = $symbols;
    }

    public function formatPercent($number, array $attributes = [], array $textAttributes = [], array $symbols = [], ?string $locale = null): string
    {
        $number = $this->parseNumericValue($number);

        return $this->format($number, \NumberFormatter::PERCENT, $attributes, $textAttributes, $symbols, $locale);
    }

    public function formatDuration($number, array $attributes = [], array $textAttributes = [], array $symbols = [], ?string $locale = null): string
    {
        $number = $this->parseNumericValue($number);

        return $this->format($number, \NumberFormatter::DURATION, $attributes, $textAttributes, $symbols, $locale);
    }

    public function formatDecimal($number, array $attributes = [], array $textAttributes = [], array $symbols = [], ?string $locale = null): string
    {
        $number = $this->parseNumericValue($number);

        return $this->format($number, \NumberFormatter::DECIMAL, $attributes, $textAttributes, $symbols, $locale);
    }

    public function formatSpellout($number, array $attributes = [], array $textAttributes = [], array $symbols = [], ?string $locale = null): string
    {
        $number = $this->parseNumericValue($number);

        return $this->format($number, \NumberFormatter::SPELLOUT, $attributes, $textAttributes, $symbols, $locale);
    }

    public function formatCurrency($number, string $currency, array $attributes = [], array $textAttributes = [], array $symbols = [], ?string $locale = null): string
    {
        $formatter = $this->getFormatter($locale ?? $this->getLocale(), \NumberFormatter::CURRENCY, $attributes, $textAttributes, $symbols);
        $number = $this->parseNumericValue($number);

        return $this->fixCharset($formatter->formatCurrency($number, $currency));
    }

    public function formatScientific($number, array $attributes = [], array $textAttributes = [], array $symbols = [], ?string $locale = null): string
    {
        $number = $this->parseNumericValue($number);

        return $this->format($number, \NumberFormatter::SCIENTIFIC, $attributes, $textAttributes, $symbols, $locale);
    }

    public function formatOrdinal($number, array $attributes = [], array $textAttributes = [], array $symbols = [], ?string $locale = null): string
    {
        $number = $this->parseNumericValue($number);

        return $this->format($number, \NumberFormatter::ORDINAL, $attributes, $textAttributes, $symbols, $locale);
    }

    public function format($number, int $style, array $attributes = [], array $textAttributes = [], array $symbols = [], ?string $locale = null): string
    {
        $formatter = $this->getFormatter($locale ?? $this->getLocale(), $style, $attributes, $textAttributes, $symbols);

        return $this->fixCharset($formatter->format($number));
    }

    /**
     * Gets an instance of \NumberFormatter set with the given attributes and
     * style.
     *
     * @param string                   $culture        The culture used by \NumberFormatter
     * @param int                      $style          The style used by \NumberFormatter
     * @param array<string, int|float> $attributes     The attributes used by \NumberFormatter
     * @param array<string, string>    $textAttributes The text attributes used by \NumberFormatter
     * @param array<string, string>    $symbols        The symbols used by \NumberFormatter
     */
    protected function getFormatter(string $culture, int $style, array $attributes = [], array $textAttributes = [], array $symbols = []): \NumberFormatter
    {
        $attributes = $this->parseAttributes(array_merge($this->attributes, $attributes));
        $textAttributes = $this->parseAttributes(array_merge($this->textAttributes, $textAttributes));
        $symbols = $this->parseAttributes(array_merge($this->symbols, $symbols));
        $formatter = new \NumberFormatter($culture, $style);

        self::checkInternalClass($formatter, \NumberFormatter::class, [
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
     * Converts keys of attributes array to values of \NumberFormatter constants.
     *
     * @param array<string, mixed> $attributes The list of attributes
     *
     * @throws \InvalidArgumentException If any attribute does not match any constant
     *
     * @return array<int, mixed> List of \NumberFormatter constants
     *
     * @phpstan-template T of mixed
     * @phpstan-param array<string, T> $attributes
     * @phpstan-return array<int, T>
     */
    protected function parseAttributes(array $attributes)
    {
        $result = [];

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
     * @throws \InvalidArgumentException If the value does not match any constant
     *
     * @return mixed The \NumberFormatter constant
     */
    protected function parseConstantValue(string $attribute)
    {
        $attribute = strtoupper($attribute);
        $constantName = 'NumberFormatter::'.$attribute;

        if (!\defined($constantName)) {
            throw new \InvalidArgumentException(sprintf('NumberFormatter has no constant "%s".', $attribute));
        }

        return \constant($constantName);
    }

    /**
     * @param string|int|float $number
     *
     * @return int|float
     */
    private function parseNumericValue($number)
    {
        if (\is_float($number) || \is_int($number)) {
            return $number;
        }

        if (is_numeric($number)) {
            return (float) $number;
        }

        throw new \TypeError('Number must be either a float, an integer or a numeric string');
    }
}
