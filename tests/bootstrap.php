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

if (file_exists($file = __DIR__.'/autoload.php')) {
    require_once $file;
} elseif (file_exists($file = __DIR__.'/autoload.php.dist')) {
    require_once $file;
}

use Sonata\IntlBundle\Templating\Helper\DateTimeHelper;

echo sprintf("ICU Version : %s\n", DateTimeHelper::getICUDataVersion());

// try to get Symfony's PHPunit Bridge
$files = array_filter([
    __DIR__.'/../vendor/symfony/symfony/src/Symfony/Bridge/PhpUnit/bootstrap.php',
    __DIR__.'/../vendor/symfony/phpunit-bridge/bootstrap.php',
    __DIR__.'/../../../../vendor/symfony/symfony/src/Symfony/Bridge/PhpUnit/bootstrap.php',
    __DIR__.'/../../../../vendor/symfony/phpunit-bridge/bootstrap.php',
], 'file_exists');
if ($files) {
    require_once current($files);
}
