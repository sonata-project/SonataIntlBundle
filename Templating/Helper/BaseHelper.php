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
use Symfony\Component\Templating\Helper\Helper;

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
    /**
     * @var LocaleDetectorInterface
     */
    protected $localeDetector;

    /**
     * @param string                  $charset        The output charset of the helper
     * @param LocaleDetectorInterface $localeDetector
     */
    public function __construct($charset, LocaleDetectorInterface $localeDetector)
    {
        $this->setCharset($charset);

        $this->localeDetector = $localeDetector;
    }

    /**
     * Typo in the method name.
     *
     * NEXT_MAJOR: remove this method
     *
     * @deprecated
     */
    public static function getUCIDataVersion()
    {
        @trigger_error(
            'The '.__METHOD__.' method is deprecated since 2.2 and will be removed on 3.0. '.
            'Use '.__CLASS__.'::getICUDataVersion instead.',
            E_USER_DEPRECATED
        );

        return self::getICUDataVersion();
    }

    /**
     * @static
     *
     * @return string
     */
    public static function getICUDataVersion()
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

        return;
    }

    /**
     * Fixes the charset by converting a string from an UTF-8 charset to the
     * charset of the kernel.
     *
     * Precondition: the kernel charset is not UTF-8
     *
     * @param string $string The string to fix
     *
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
     * https://wiki.php.net/rfc/internal_constructor_behaviour.
     *
     * @param mixed  $instance
     * @param string $class
     * @param array  $args
     */
    protected static function checkInternalClass($instance, $class, array $args = array())
    {
        if ($instance !== null) {
            return;
        }

        $messages = array();
        foreach ($args as $name => $value) {
            $messages[] = sprintf('%s => %s', $name, $value);
        }

        throw new \RuntimeException(sprintf(
            'Unable to create internal class: %s, with params: %s',
            $class,
            implode(', ', $messages)
        ));
    }
}
