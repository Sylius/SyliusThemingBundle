<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * This bundle replaces the default Symfony2 delegating engine.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SyliusThemingBundle extends Bundle
{
    public function getParent()
    {
        return 'LiipThemeBundle';
    }
}
