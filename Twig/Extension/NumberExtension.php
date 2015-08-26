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
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonata_intl_number';
    }
}
