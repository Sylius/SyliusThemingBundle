<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\Manipulator;

use Sylius\Bundle\ThemingBundle\Model\ThemeInterface;

/**
 * Theme manipulator interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface ThemeManipulatorInterface
{
    /**
     * Creates a theme.
     *
     * @param ThemeInterface $theme
     */
    function install(ThemeInterface $theme);

    /**
     * Deletes a theme.
     *
     * @param ThemeInterface $theme
     */
    function uninstall(ThemeInterface $theme);

    /**
     * Enable a theme.
     *
     * @param ThemeInterface $theme
     */
    function enable(ThemeInterface $theme);

    /**
     * Disable a theme.
     *
     * @param ThemeInterface $theme
     */
    function disable(ThemeInterface $theme);
}
