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

/**
 * DateTimeExtension extends Twig with localized date/time capabilities.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 */
class DateTimeExtension extends \Twig_Extension
{

    protected $helper;
    
    public function __construct($helper)
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
            'format_date'     => new \Twig_Filter_Method($this, 'formatDate', array('is_safe' => array('html'))),
            'format_time'     => new \Twig_Filter_Method($this, 'formatTime', array('is_safe' => array('html'))),
            'format_datetime' => new \Twig_Filter_Method($this, 'formatDatetime', array('is_safe' => array('html'))),
        );
    }

    public function formatDate($date, $pattern = null, $locale = null)
    {
        if ($pattern) {
            return $this->helper->format($date, $pattern, $locale);
        }

        return $this->helper->formatDate($date, $locale);
    }

    public function formatTime($time, $pattern = null, $locale = null)
    {
        if ($pattern) {
            return $this->helper->format($time, $pattern, $locale);
        }

        return $this->helper->formatTime($time, $locale);
    }

    public function formatDatetime($time, $pattern = null, $locale = null)
    {
        if ($pattern) {
            return $this->helper->format($time, $pattern, $locale);
        }

        return $this->helper->formatDateTime($time, $locale);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'sonata_intl_datetime';
    }
}