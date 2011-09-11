<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\EventDispatcher;

/**
 * Events.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
final class SyliusThemingEvents
{
    const THEME_ENABLE      = 'sylius_theming.event.theme.enable';
    const THEME_DISABLE     = 'sylius_theming.event.theme.disable';
    const THEME_ACTIVATE    = 'sylius_theming.event.theme.activate';
    const THEME_INSTALL     = 'sylius_theming.event.theme.install';
    const THEME_UNINSTALL   = 'sylius_theming.event.theme.uninstall';
}
