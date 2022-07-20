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

namespace Sonata\IntlBundle\Timezone;

use Sonata\UserBundle\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Detects timezones based on the detected locale.
 *
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
class UserBasedTimezoneDetector implements TimezoneDetectorInterface
{
    /**
     * @var TokenStorageInterface
     */
    protected $securityContext;

    public function __construct(TokenStorageInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function getTimezone()
    {
        $token = $this->securityContext->getToken();
        if (null === $token) {
            return null;
        }

        $user = $token->getUser();
        if (null === $user) {
            return null;
        }

        if ($user instanceof TimezoneAwareInterface) {
            return $user->getTimezone();
        }

        /**
         * NEXT_MAJOR: Remove this check and the related documentation at `docs/reference/configuration.rst`.
         *
         * @psalm-suppress UndefinedClass
         */
        if ($user instanceof User) {
            @trigger_error(sprintf(
                'Timezone inference based on the "%s" class is deprecated since sonata-project/intl-bundle 2.8 and will be dropped in 3.0 version.'
                .' Implement "%s" explicitly in your user class instead.',
                User::class,
                TimezoneAwareInterface::class
            ), \E_USER_DEPRECATED);

            /**
             * @psalm-suppress UndefinedInterfaceMethod
             */
            return $user->getTimezone();
        }

        return null;
    }
}
