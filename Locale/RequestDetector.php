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
        if ($this->container->isScopeActive('request')) {
            if ($request = $this->container->get('request', ContainerInterface::NULL_ON_INVALID_REFERENCE)) {
                return $request->getLocale();
            }
        }

        return $this->defaultLocale;
    }
}
