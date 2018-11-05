<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class RegisterEventHandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $registry = $container->getDefinition('App\Application\Event\EventHandlerRegistry');

        foreach ($container->findTaggedServiceIds('kork.event.handler') as $id => $tags) {
            $registry->addMethodCall('register', [new Reference($id)]);
        }
    }
}
