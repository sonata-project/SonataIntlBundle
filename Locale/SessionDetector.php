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

use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpKernel\Kernel;
use Sonata\IntlBundle\SonataIntlBundle;

class SessionDetector implements LocaleDetectorInterface
{
    protected $session;

    protected $defaultLocale;

    /**
     * @param \Symfony\Component\HttpFoundation\Session $session
     * @param string                                    $defaultLocale
     */
    public function __construct(Session $session, $defaultLocale)
    {
        if (!version_compare(SonataIntlBundle::getSymfonyVersion(Kernel::VERSION), '2.1.0', '<')) {
            throw new \RuntimeException('Invalid Symfony2 version, please use Symfony 2.0.x series');
        }

        $this->session        = $session;
        $this->defaultLocale  = $defaultLocale;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        if ($this->session) {
            return $this->session->getLocale();
        }

        return $this->defaultLocale;
    }
}
