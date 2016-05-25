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

use Sonata\IntlBundle\Templating\Helper\LocaleHelper;

/**
 * LocaleExtension extends Twig with local capabilities.
 *
 * @author Thomas Rabaix <thomas.rabaix@ekino.com>
 */
class LocaleExtension extends \Twig_Extension
{
    /**
     * @var LocaleHelper
     */
    protected $helper;

    /**
     * @param LocaleHelper $helper
     */
    public function __construct(LocaleHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('country', array($this, 'country'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('locale', array($this, 'locale'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('language', array($this, 'language'), array('is_safe' => array('html'))),
        );
    }

    /**
     * Returns the localized country name from the provided code.
     *
     * @param string      $code
     * @param string|null $locale
     *
     * @return string
     */
    public function country($code, $locale = null)
    {
        return $this->helper->country($code, $locale);
    }

    /**
     * Returns the localized locale name from the provided code.
     *
     * @param string      $code
     * @param string|null $locale
     *
     * @return string
     */
    public function locale($code, $locale = null)
    {
        return $this->helper->locale($code, $locale);
    }

    /**
     * Returns the localized language name from the provided code.
     *
     * @param string      $code
     * @param string|null $locale
     *
     * @return string
     */
    public function language($code, $locale = null)
    {
        return $this->helper->language($code, $locale);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonata_intl_locale';
    }
}
