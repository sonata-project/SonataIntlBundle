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

use Sonata\IntlBundle\Templating\Helper\LocaleHelper;

/**
 * LocaleExtension extends Twig with local capabilities.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 */
class LocaleExtension extends \Twig_Extension
{
    protected $helper;

    public function __construct(LocaleHelper $helper)
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
            'country'    => new \Twig_Filter_Method($this, 'country', array('is_safe' => array('html'))),
            'locale'     => new \Twig_Filter_Method($this, 'locale', array('is_safe' => array('html'))),
            'language'   => new \Twig_Filter_Method($this, 'language', array('is_safe' => array('html'))),
        );
    }

    /**
     * return the localized country name from the provided code
     *
     * @param  $code
     * @param  null   $locale
     * @return string
     */
    public function country($code, $locale = null)
    {
        return $this->helper->country($code, $locale);
    }

    /**
     * return the localized locale name from the provided code
     *
     * @param  $code
     * @param  null   $locale
     * @return string
     */
    public function locale($code, $locale = null)
    {
        return $this->helper->locale($code, $locale);
    }

    /**
     * return the localized language name from the provided code
     *
     * @param  $code
     * @param  null   $locale
     * @return string
     */
    public function language($code, $locale = null)
    {
        return $this->helper->language($code, $locale);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'sonata_intl_locale';
    }
}
