<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\Controller\Frontend;

use Sylius\Bundle\ThemingBundle\EventDispatcher\Event\FilterThemeEvent;
use Sylius\Bundle\ThemingBundle\EventDispatcher\SyliusThemingEvents;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Theme frontend controller.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ThemeController extends ContainerAware
{
    /**
     * List themes.
     *
     * @return Response
     */
    public function listAction()
    {
        $themes = $this->container->get('sylius_theming.manager.theme')->findThemesBy(array('enabled' => true));

        return $this->container->get('templating')->renderResponse('SyliusThemingBundle:Frontend/Theme:list.html.'.$this->getEngine(), array(
            'themes' => $themes
        ));
    }

    /**
     * Switch the theme.
     *
     * @param mixed $id Theme id
     *
     * @return Response
     */
    public function switchAction($id)
    {
        if (!$theme = $this->container->get('sylius_theming.manager.theme')->findTheme($id)) {
            throw new NotFoundHttpException('Requested theme does not exist');
        }

        $this->container->get('event_dispatcher')->dispatch(SyliusThemingEvents::THEME_SWITCH, new FilterThemeEvent($theme));
        $this->container->get('sylius_theming.resolver')->switchTheme($theme);
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
