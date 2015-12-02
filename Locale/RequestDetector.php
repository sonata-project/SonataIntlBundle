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
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel;

class RequestDetector implements LocaleDetectorInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var string
     */
    protected $defaultLocale;

    /**
     * @param ContainerInterface $container
     * @param string             $defaultLocale
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
     * {@inheritdoc}
     */
    public function getLocale()
    {
        if ($request = $this->getRequest()) {
            return $request->getLocale();
        }

        return $this->defaultLocale;
    }

    /**
     * @return Request|null
     */
    private function getRequest()
    {
        $request = null;
        if ($this->container->has('request_stack')) {
            $request = $this->container->get('request_stack')->getCurrentRequest();
        } elseif (method_exists($this->container, 'isScopeActive') && $this->container->isScopeActive('request')) {
            $request = $this->container->get('request');
        }

        return $request;
    }
}
