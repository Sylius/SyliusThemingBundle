<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\Controller\Backend;

use Sylius\Bundle\ThemingBundle\EventDispatcher\Event\FilterThemeEvent;
use Sylius\Bundle\ThemingBundle\EventDispatcher\SyliusThemingEvents;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Theme backend controller.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ThemeController extends ContainerAware
{
    /**
     * Shows a theme.
     *
     * @param mixed $id Theme id
     *
     * @return Response
     */
    public function showAction($id)
    {
        $theme = $this->findThemeOr404($id);

        return $this->container->get('templating')->renderResponse('SyliusThemingBundle:Backend/Theme:show.html.'.$this->getEngine(), array(
            'theme' => $theme
        ));
    }

    /**
     * List themes.
     *
     * @return Response
     */
    public function listAction()
    {
        $themes   = $this->container->get('sylius_theming.manager.theme')->findThemes();
        $packages = $this->container->get('sylius_theming.packager')->findPackages($themes);

        return $this->container->get('templating')->renderResponse('SyliusThemingBundle:Backend/Theme:list.html.'.$this->getEngine(), array(
            'themes'   => $themes,
            'packages' => $packages
        ));
    }

    /**
     * Installs a new theme from package.
     *
     * @param string $hash
     *
     * @return Response
     */
    public function installAction($hash)
    {
        $package = $this->container->get('sylius_theming.packager')->createPackages($hash);
        $theme = $package->buildTheme($this->container->get('sylius_theming.manager.theme')->createTheme());

        if (0 === count($this->container->get('validator')->validate($theme))) {
            $this->container->get('event_dispatcher')->dispatch(SyliusThemingEvents::THEME_INSTALL, new FilterThemeEvent($theme));
            $this->container->get('sylius_theming.manipulator.theme')->install($theme);

            return new RedirectResponse($this->container->get('router')->generate('sylius_theming_backend_theme_list'));
        }
    }

    /**
     * Deletes themes.
     *
     * @param mixed $id Theme id
     *
     * @return Response
     */
    public function uninstallAction($id)
    {
        $theme = $this->findThemeOr404($id);

        $this->container->get('event_dispatcher')->dispatch(SyliusThemingEvents::THEME_UNINSTALL, new FilterThemeEvent($theme));
        $this->container->get('sylius_theming.manipulator.theme')->uninstall($theme);

        return new RedirectResponse($this->container->get('router')->generate('sylius_theming_backend_theme_list'));
    }

    /**
     * Switches active theme.
     *
     * @param mixed $id Theme id
     *
     * @return Response
     */
    public function switchAction($id)
    {
        $theme = $this->findThemeOr404($id);

        $this->container->get('event_dispatcher')->dispatch(SyliusThemingEvents::THEME_SWITCH, new FilterThemeEvent($theme));
        $this->container->get('sylius_theming.resolver')->switchTheme($theme);

        return new RedirectResponse($this->container->get('request')->headers->get('referer'));
    }

    /**
     * Toggle enable/disable theme.
     *
     * @param mixed $id Theme id
     *
     * @return Response
     */
    public function toggleAction($id)
    {
        $theme = $this->findThemeOr404($id);

        if ($theme->isEnabled()) {
            $this->container->get('event_dispatcher')->dispatch(SyliusThemingEvents::THEME_DISABLE, new FilterThemeEvent($theme));
            $this->container->get('sylius_theming.manipulator.theme')->disable($theme);
        } else {
            $this->container->get('event_dispatcher')->dispatch(SyliusThemingEvents::THEME_ENABLE, new FilterThemeEvent($theme));
            $this->container->get('sylius_theming.manipulator.theme')->enable($theme);
        }

        return new RedirectResponse($this->container->get('request')->headers->get('referer'));
    }

    /**
     * Tries to find theme by id.
     * Throws 404 http exception when unsuccessful.
     *
     * @param mixed $id Theme id
     *
     * @return ThemeInterface
     *
     * @throws NotFoundHttpException
     */
    public function findThemeOr404($id)
    {
        if (!$theme = $this->container->get('sylius_theming.manager.theme')->findTheme($id)) {
            throw new NotFoundHttpException('Requested theme does not exist');
        }

        return $theme;
    }

    /**
     * Returns templating engine name.
     *
     * @return string
     */
    protected function getEngine()
    {
        return $this->container->getParameter('sylius_theming.engine');
    }
}
