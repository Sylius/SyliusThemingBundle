<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\Model;

/**
 * Theme manager interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface ThemeManagerInterface
{
    function createTheme();
    function persistTheme(ThemeInterface $theme);
    function removeTheme(ThemeInterface $theme);
    function findTheme($id);
    function findThemeBy(array $criteria);
    function findThemes();
    function findThemesBy(array $criteria);
    function getClass();
}
