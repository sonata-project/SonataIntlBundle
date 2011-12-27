<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\IntlBundle\Locale;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel;

class RequestDetector implements LocaleDetectorInterface
{
    protected $request;

    protected $defaultLocale;

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $defaultLocale
     */
    public function __construct(Request $request, $defaultLocale)
    {
        if (version_compare(Kernel::VERSION, '2.1.0-DEV', '<')) {
            throw new \RuntimeException('Invalid Symfony2 version, please use Symfony 2.1.x series');
        }

        $this->request        = $request;
        $this->defaultLocale  = $defaultLocale;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        if ($this->request) {
            return $this->request->getLocale();
        }

        return $this->defaultLocale;
    }
}