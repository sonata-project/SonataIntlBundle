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

use Symfony\Component\Templating\Helper\Helper;
use Sonata\IntlBundle\Locale\LocaleDetectorInterface;

/**
 * BaseHelper provides charset conversion.
 *
 * The php Intl extension will always output UTF-8 encoded strings [1]. If the
 * framework is configured to use another encoding than UTF-8 this will lead to
 * garbled text. The BaseHelper provides functionality to the other helpers to
 * convert from UTF-8 to the kernel charset.
 *
 * [1] http://www.php.net/manual/en/intl.examples.basic.php
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
abstract class BaseHelper extends Helper
{
    protected $localeDetector;

    /**
     * Constructor.
     *
     * @param string                                            $charset        The output charset of the helper
     * @param \Sonata\IntlBundle\Locale\LocaleDetectorInterface $localeDetector
     */
    public function __construct($charset, LocaleDetectorInterface $localeDetector)
    {
        $this->setCharset($charset);

        $this->localeDetector = $localeDetector;
    }

    /**
     * Fixes the charset by converting a string from an UTF-8 charset to the
     * charset of the kernel.
     *
     * Precondition: the kernel charset is not UTF-8
     *
     * @param  string $string The string to fix
     * @return string A string with the %kernel.charset% encoding
     */
    protected function fixCharset($string)
    {
        if ('UTF-8' !== $this->getCharset()) {
            $string = mb_convert_encoding($string, $this->getCharset(), 'UTF-8');
        }

        return $string;
    }

    /**
     * @static
     * @return string
     */
    public static function getUCIDataVersion()
    {
        if (defined('INTL_ICU_VERSION')) {
            return INTL_ICU_VERSION;
        }

        ob_start();
        phpinfo();
        $content = ob_get_contents();
        ob_end_clean();

        $info = explode("\n", $content);

        if ('cli' == php_sapi_name()) {
            foreach ($info as $line) {
                $results = array();

                if (preg_match('/(ICU Data version|ICU version) => (.*)/', $line, $results)) {
                    return $results[2];
                }
            }
        } else {
            foreach ($info as $line) {
                $results = array();

                if (preg_match('/(ICU Data version).*/', $line, $results)) {
                    return trim(strtolower(strip_tags($results[0])), 'ICU Data version');
                }

                if (preg_match('/(ICU version).*/', $line, $results)) {
                    return trim(strtolower(strip_tags($results[0])), 'icu version');
                }
            }
        }

        return null;
    }
}
