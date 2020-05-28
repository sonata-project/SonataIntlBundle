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

/**
 * Basic Implementation of TimezoneAwareInterface.
 *
 * @author Javier Spagnoletti <phansys@gmail.com>
 */
trait TimezoneAwareTrait
{
    /**
     * @var string|null
     */
    private $timezone;

    final public function getTimezone(): ?string
    {
        return $this->timezone;
    }
}
