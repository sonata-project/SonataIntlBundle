<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\IntlBundle\Locale;

use Symfony\Component\DependencyInjection\ContainerInterface;

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
        $this->container = $container;
        $this->defaultLocale = $defaultLocale;
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
