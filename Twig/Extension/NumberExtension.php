<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\IntlBundle\Twig\Extension;

use Sonata\IntlBundle\Templating\Helper\NumberHelper;

/**
 * NumberExtension extends Twig with number capabilities.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 */
class NumberExtension extends \Twig_Extension
{

    protected $helper;

    public function __construct(NumberHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Returns the token parser instance to add to the existing list.
     *
     * @return array An array of Twig_TokenParser instances
     */
    public function getTokenParsers()
    {
        return array(
        );
    }

    public function getFilters()
    {
        return array(
            'number_format_currency'    => new \Twig_Filter_Method($this, 'formatCurrency', array('is_safe' => array('html'))),
            'number_format_decimal'     => new \Twig_Filter_Method($this, 'formatDecimal', array('is_safe' => array('html'))),
            'number_format_scientific'  => new \Twig_Filter_Method($this, 'formatScientific', array('is_safe' => array('html'))),
            'number_format_spellout'    => new \Twig_Filter_Method($this, 'formatSpellout', array('is_safe' => array('html'))),
            'number_format_percent'     => new \Twig_Filter_Method($this, 'formatPercent', array('is_safe' => array('html'))),
            'number_format_duration'    => new \Twig_Filter_Method($this, 'formatDuration', array('is_safe' => array('html'))),
            'number_format_ordinal'     => new \Twig_Filter_Method($this, 'formatOrdinal', array('is_safe' => array('html'))),
        );
    }

    public function formatCurrency($number, $currency, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        return $this->helper->formatCurrency($number, $currency, $attributes, $textAttributes, $locale);
    }

    public function formatDecimal($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        return $this->helper->formatDecimal($number, $attributes, $textAttributes, $locale);
    }

    public function formatScientific($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        return $this->helper->formatScientific($number, $attributes, $textAttributes, $locale);
    }

    public function formatSpellout($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        return $this->helper->formatSpellout($number, $attributes, $textAttributes, $locale);
    }

    public function formatPercent($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        return $this->helper->formatPercent($number, $attributes, $textAttributes, $locale);
    }

    public function formatDuration($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        return $this->helper->formatDuration($number, $attributes, $textAttributes, $locale);
    }

    public function formatOrdinal($number, array $attributes = array(), array $textAttributes = array(), $locale = null)
    {
        return $this->helper->formatOrdinal($number, $attributes, $textAttributes, $locale);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'sonata_intl_number';
    }
}
