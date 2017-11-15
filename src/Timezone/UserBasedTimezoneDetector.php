<?php

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
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Detects timezones based on the detected locale.
 *
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
class UserBasedTimezoneDetector implements TimezoneDetectorInterface
{
    /**
     * @var SecurityContextInterface|TokenStorageInterface
     */
    protected $securityContext;

    /**
     * @param SecurityContextInterface|TokenStorageInterface $securityContext
     */
    public function __construct($securityContext)
    {
        if (!$securityContext instanceof TokenStorageInterface && !$securityContext instanceof SecurityContextInterface) {
            throw new \InvalidArgumentException('Argument 1 should be an instance of Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface or Symfony\Component\Security\Core\SecurityContextInterface');
        }

        $this->securityContext = $securityContext;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimezone()
    {
        if (!$token = $this->securityContext->getToken()) {
            return;
        }

        if (!$user = $token->getUser()) {
            return;
        }

        if ($user instanceof User) {
            return $user->getTimezone();
        }
    }
}
