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

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Detects timezones based on the detected locale.
 *
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
class UserBasedTimezoneDetector implements TimezoneDetectorInterface
{
    public function __construct(protected TokenStorageInterface $securityContext)
    {
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

        return null;
    }
}
