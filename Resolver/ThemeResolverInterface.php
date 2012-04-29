<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\Resolver;

use Sylius\Bundle\ThemingBundle\Model\ThemeInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface for theme resolver.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface ThemeResolverInterface
{
    /**
     * Resolves current theme.
     * Can do it basing on current request.
     *
     * @param Request $request
     */
    function resolveActiveTheme(Request $request);

    /**
     * Switch active theme.
     *
     * @param ThemeInterface $theme
     */
    function switchActiveTheme(ThemeInterface $theme);
}
