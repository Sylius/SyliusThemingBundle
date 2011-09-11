<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Theming compiler pass.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ThemingPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container->setAlias('templating.locator', 'sylius_theming.locator.template');
    }
}
