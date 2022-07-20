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

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * NEXT_MAJOR: remove this class.
 *
 * @deprecated since sonata-project/intl-bundle 2.13, to be removed in version 3.0.
 */
class RequestStackDetector implements LocaleDetectorInterface
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var string
     */
    protected $defaultLocale;

    /**
     * @param string $defaultLocale
     */
    public function __construct(RequestStack $requestStack, $defaultLocale)
    {
        $this->requestStack = $requestStack;
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        $request = $this->requestStack->getCurrentRequest();

        if (null !== $request) {
            return $request->getLocale();
        }

        return $this->defaultLocale;
    }
}
