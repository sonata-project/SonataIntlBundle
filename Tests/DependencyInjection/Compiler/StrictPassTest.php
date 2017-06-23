<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\IntlBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Sonata\IntlBundle\DependencyInjection\Compiler\StrictPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class StrictPassTest extends AbstractCompilerPassTestCase
{
    protected function setUp()
    {
        parent::setUp();

        if (!method_exists('Symfony\Component\DependencyInjection\Reference', 'isStrict')) {
            $this->markTestSkipped('Requires Symfony 2.x');
        }
    }

    public function testStrictParameter()
    {
        $requestDef = new Definition();
        $requestDef->addArgument(new Reference('service_container', ContainerInterface::NULL_ON_INVALID_REFERENCE, false));

        $this->setDefinition('sonata.intl.locale_detector.request', $requestDef);

        $sessionDef = new Definition();
        $sessionDef->addArgument(new Reference('session', ContainerInterface::NULL_ON_INVALID_REFERENCE, false));

        $this->setDefinition('sonata.intl.locale_detector.session', $sessionDef);

        $this->compile();

        $this->assertFalse($requestDef->getArgument(0)->isStrict());
        $this->assertFalse($sessionDef->getArgument(0)->isStrict());
    }

    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new StrictPass());
    }
}
