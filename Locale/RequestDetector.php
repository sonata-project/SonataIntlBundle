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

use Sonata\IntlBundle\SonataIntlBundle;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Kernel;

class RequestDetector implements LocaleDetectorInterface
{
    protected $container;

    protected $defaultLocale;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param string                                                    $defaultLocale
     */
    public function __construct(ContainerInterface $container, $defaultLocale)
    {
        if (version_compare(SonataIntlBundle::getSymfonyVersion(Kernel::VERSION), '2.1.0', '<')) {
            throw new \RuntimeException('Invalid Symfony2 version, please use Symfony 2.1.x series');
        }

        $this->container      = $container;
        $this->defaultLocale  = $defaultLocale;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        if ($this->container->isScopeActive("request")) {
            if ($request = $this->container->get('request', ContainerInterface::NULL_ON_INVALID_REFERENCE)) {
                return $request->getLocale();
            }
        }
        return $this->defaultLocale;
    }
}
