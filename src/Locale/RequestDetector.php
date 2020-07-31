<?php

declare(strict_types=1);

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

/**
 * NEXT_MAJOR: remove this class.
 *
 * @deprecated since sonata-project/intl-bundle 2.8, to be removed in version 3.0.
 */
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
     * @param string $defaultLocale
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
