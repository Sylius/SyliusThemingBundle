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

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sylius\Bundle\ThemingBundle\EventDispatcher\Event\FilterThemeEvent;
use Sylius\Bundle\ThemingBundle\EventDispatcher\SyliusThemingEvents;

/**
 * Theme frontend controller.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ThemeController extends ContainerAware
{
    /**
     * List themes.
     */
    public function listAction()
    {
        $themes = $this->container->get('sylius_theming.manager.theme')->findThemesBy(array('enabled' => true));
        
        return $this->container->get('templating')->renderResponse('SyliusThemingBundle:Frontend/Theme:list.html.' . $this->getEngine(), array(
            'themes' => $themes
        ));
    }
    
    /**
     * Chose the theme.
     */
    public function activateAction($id)
    {
        $theme = $this->container->get('sylius_theming.manager.theme')->findTheme($id);
        
        if (!$theme) {
            throw new NotFoundHttpException('Requested theme does not exist.');
        }
        
        $this->container->get('event_dispatcher')->dispatch(SyliusThemingEvents::THEME_ACTIVATE, new FilterThemeEvent($theme));
        $this->container->get('sylius_theming.resolver')->setActiveTheme($theme);
        
        $response = new RedirectResponse($this->container->get('router')->generate('sylius_theming_theme_list'));
        $response->headers->setCookie(new Cookie('SYLIUS_THEMING_THEME', $theme->getId()));
        
        return $response;
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
