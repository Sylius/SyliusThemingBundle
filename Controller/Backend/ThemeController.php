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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @param string $id Package identifier
     *
     * @return Response
     */
    public function installAction($id)
    {
        $package = $this->container->get('sylius_theming.packager')->findPackage($id);

        if (!$package) {
            throw new NotFoundHttpException('Requested theme package does not exist');
        }

        $theme = $package->buildTheme($this->container->get('sylius_theming.manager.theme')->createTheme());

        if (0 === count($this->container->get('validator')->validate($theme))) {
            $this->container->get('event_dispatcher')->dispatch(SyliusThemingEvents::THEME_INSTALL, new FilterThemeEvent($theme));
            $this->container->get('sylius_theming.manipulator.theme')->install($theme);

            return $this->redirectToThemeList();
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

        return $this->redirectToThemeList();
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

        return $this->redirectReferer();
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

        return $this->redirectReferer();
    }

    /**
     * Download theme package.
     *
     * @return Response
     */
    public function downloadAction()
    {
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
     * Safely redirect to referer.
     *
     * @return RedirectResponse
     */
    public function redirectReferer()
    {
        if (null !== $url = $this->container->get('request')->headers->get('referer')) {
            return new RedirectResponse($url);
        }

        return $this->redirectToThemeList();
    }

    /**
     * Redirect to theme list.
     *
     * @return RedirectResponse
     */
    public function redirectToThemeList()
    {
        return new RedirectResponse($this->container->get('router')->generate('sylius_theming_backend_theme_list'));
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
