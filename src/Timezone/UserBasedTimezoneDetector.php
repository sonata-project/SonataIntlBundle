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
    protected $securityContext;

    public function __construct(TokenStorageInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimezone()
    {
        if (!$token = $this->securityContext->getToken()) {
            return null;
        }

        if (!$user = $token->getUser()) {
            return null;
        }

        if ($user instanceof TimezoneAwareInterface) {
            return $user->getTimezone();
        }

        return null;
    }
}
