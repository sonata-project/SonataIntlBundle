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

namespace Sonata\IntlBundle\Twig;

use Sonata\IntlBundle\Helper\LocalizerInterface;
use Twig\Extension\RuntimeExtensionInterface;

final class LocaleRuntime implements RuntimeExtensionInterface
{
    public function __construct(private LocalizerInterface $helper)
    {
    }

    /**
     * Returns the localized country name from the provided code.
     */
    public function country(string $code, ?string $locale = null): string
    {
        return $this->helper->country($code, $locale);
    }

    /**
     * Returns the localized locale name from the provided code.
     */
    public function locale(string $code, ?string $locale = null): string
    {
        return $this->helper->locale($code, $locale);
    }

    /**
     * Returns the localized language name from the provided code.
     */
    public function language(string $code, ?string $locale = null): string
    {
        return $this->helper->language($code, $locale);
    }
}
