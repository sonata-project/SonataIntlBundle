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

use Sonata\IntlBundle\Helper\NumberFormatterInterface;
use Twig\Extension\RuntimeExtensionInterface;

final class NumberRuntime implements RuntimeExtensionInterface
{
    public function __construct(private NumberFormatterInterface $helper)
    {
    }

    /**
     * Formats a number as currency according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int         $number         The number to format
     * @param string                   $currency       The currency in which format the number
     * @param array<string, int|float> $attributes     The attributes used by \NumberFormatter
     * @param array<string, string>    $textAttributes The text attributes used by \NumberFormatter
     * @param array<string, string>    $symbols        The symbols used by \NumberFormatter
     *
     * @return string The formatted number
     */
    public function formatCurrency(
        string|float|int $number,
        string $currency,
        array $attributes = [],
        array $textAttributes = [],
        array $symbols = [],
        ?string $locale = null
    ): string {
        return $this->helper->formatCurrency($number, $currency, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number as decimal according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int         $number         The number to format
     * @param array<string, int|float> $attributes     The attributes used by \NumberFormatter
     * @param array<string, string>    $textAttributes The text attributes used by \NumberFormatter
     * @param array<string, string>    $symbols        The symbols used by \NumberFormatter
     *
     * @return string The formatted number
     */
    public function formatDecimal(
        string|float|int $number,
        array $attributes = [],
        array $textAttributes = [],
        array $symbols = [],
        ?string $locale = null
    ): string {
        return $this->helper->formatDecimal($number, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number in scientific notation according to the specified
     * locale and \NumberFormatter attributes.
     *
     * @param string|float|int         $number         The number to format
     * @param array<string, int|float> $attributes     The attributes used by \NumberFormatter
     * @param array<string, string>    $textAttributes The text attributes used by \NumberFormatter
     * @param array<string, string>    $symbols        The symbols used by \NumberFormatter
     *
     * @return string The formatted number
     */
    public function formatScientific(
        string|float|int $number,
        array $attributes = [],
        array $textAttributes = [],
        array $symbols = [],
        ?string $locale = null
    ): string {
        return $this->helper->formatScientific($number, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number as spellout according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int         $number         The number to format
     * @param array<string, int|float> $attributes     The attributes used by \NumberFormatter
     * @param array<string, string>    $textAttributes The text attributes used by \NumberFormatter
     * @param array<string, string>    $symbols        The symbols used by \NumberFormatter
     *
     * @return string The formatted number
     */
    public function formatSpellout(
        string|float|int $number,
        array $attributes = [],
        array $textAttributes = [],
        array $symbols = [],
        ?string $locale = null
    ): string {
        return $this->helper->formatSpellout($number, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number as percent according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int         $number         The number to format
     * @param array<string, int|float> $attributes     The attributes used by \NumberFormatter
     * @param array<string, string>    $textAttributes The text attributes used by \NumberFormatter
     * @param array<string, string>    $symbols        The symbols used by \NumberFormatter
     *
     * @return string The formatted number
     */
    public function formatPercent(
        string|float|int $number,
        array $attributes = [],
        array $textAttributes = [],
        array $symbols = [],
        ?string $locale = null
    ): string {
        return $this->helper->formatPercent($number, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number as duration according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int         $number         The number to format
     * @param array<string, int|float> $attributes     The attributes used by \NumberFormatter
     * @param array<string, string>    $textAttributes The text attributes used by \NumberFormatter
     * @param array<string, string>    $symbols        The symbols used by \NumberFormatter
     *
     * @return string The formatted number
     */
    public function formatDuration(
        string|float|int $number,
        array $attributes = [],
        array $textAttributes = [],
        array $symbols = [],
        ?string $locale = null
    ): string {
        return $this->helper->formatDuration($number, $attributes, $textAttributes, $symbols, $locale);
    }

    /**
     * Formats a number as ordinal according to the specified locale and
     * \NumberFormatter attributes.
     *
     * @param string|float|int         $number         The number to format
     * @param array<string, int|float> $attributes     The attributes used by \NumberFormatter
     * @param array<string, string>    $textAttributes The text attributes used by \NumberFormatter
     * @param array<string, string>    $symbols        The symbols used by \NumberFormatter
     *
     * @return string The formatted number
     */
    public function formatOrdinal(
        string|float|int $number,
        array $attributes = [],
        array $textAttributes = [],
        array $symbols = [],
        ?string $locale = null
    ): string {
        return $this->helper->formatOrdinal($number, $attributes, $textAttributes, $symbols, $locale);
    }
}
