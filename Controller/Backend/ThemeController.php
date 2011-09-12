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

use RuntimeException;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Finder\Finder;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sylius\Bundle\ThemingBundle\Model\ThemePack;
use Sylius\Bundle\ThemingBundle\EventDispatcher\Event\FilterThemeEvent;
use Sylius\Bundle\ThemingBundle\EventDispatcher\SyliusThemingEvents;

/**
 * Theme backend controller.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ThemeController extends ContainerAware
{
    /**
     * Shows a theme.
     */
    public function showAction($id)
    {
        $theme = $this->container->get('sylius_theming.manager.theme')->findTheme($id);
        
        if (!$theme) {
            throw new NotFoundHttpException('Requested theme does not exist.');
        }
        
        return $this->container->get('templating')->renderResponse('SyliusThemingBundle:Backend/Theme:show.html.' . $this->getEngine(), array(
        	'theme' => $theme
        ));
    }
    
    /**
     * List themes.
     */
    public function listAction()
    {
        $themeManager = $this->container->get('sylius_theming.manager.theme');
        $themes = $themeManager->findThemes();
        
        $themesDir = $this->container->getParameter('sylius_theming.directory');
        
        if (!file_exists($themesDir)) {
            throw new RuntimeException(sprintf('Themes dir "%s" does not exist!', $themesDir));
        }
        
        $finder = new Finder();
        $packsIterator = $finder->directories()->depth(0)->in($themesDir)->getIterator();
        $packs = array();
        $installedThemesPaths = array();
        
        foreach ($themes as $theme) {
            $installedThemesPaths[] = $themesDir . '/' . $theme->getLogicalName();
        }
        
        foreach ($packsIterator as $path) {
            if (!in_array($path, $installedThemesPaths)) {
                $packs[] = new ThemePack($path);
            }
        }
        
        return $this->container->get('templating')->renderResponse('SyliusThemingBundle:Backend/Theme:list.html.' . $this->getEngine(), array(
        	'themes'    => $themes,
            'packs'     => $packs
        ));
    }
    
    /**
     * Installs a new theme.
     */
    public function installAction($path)
    {
        $path = base64_decode($path); 
        $pack = new ThemePack($path);
        
        $theme = $pack->createTheme($this->container->get('sylius_theming.manager.theme')->createTheme());
        
        if (0 === count($this->container->get('validator')->validate($theme))) {
            $this->container->get('event_dispatcher')->dispatch(SyliusThemingEvents::THEME_INSTALL, new FilterThemeEvent($theme));
            $this->container->get('sylius_theming.manipulator.theme')->install($theme);
            $this->container->get('sylius_theming.cache')->remove('sylius_theming.themes');
            
            return new RedirectResponse($this->container->get('router')->generate('sylius_theming_backend_theme_list'));
        }
        
        throw new RuntimeException('Theme configuration was invalid.');
    }

	/**
     * Deletes themes.
     */
    public function uninstallAction($id)
    {
        $theme = $this->container->get('sylius_theming.manager.theme')->findTheme($id);
        
        if (!$theme) {
            throw new NotFoundHttpException('Requested theme does not exist.');
        }
        
        if ($theme->getLogicalName() === $this->container->get('liip_theme.active_theme')->getName()) {
            $this->container->get('sylius_theming.cache')->remove('sylius_theming.active_theme');
        }
        
        $this->container->get('event_dispatcher')->dispatch(SyliusThemingEvents::THEME_UNINSTALL, new FilterThemeEvent($theme));
        $this->container->get('sylius_theming.manipulator.theme')->uninstall($theme);
        $this->container->get('sylius_theming.cache')->remove('sylius_theming.themes');
        
        return new RedirectResponse($this->container->get('router')->generate('sylius_theming_backend_theme_list'));
    }
    
	/**
     * Activates theme.
     */
    public function activateAction($id)
    {
        $theme = $this->container->get('sylius_theming.manager.theme')->findTheme($id);
        
        if (!$theme) {
            throw new NotFoundHttpException('Requested theme does not exist.');
        }
        
        $this->container->get('event_dispatcher')->dispatch(SyliusThemingEvents::THEME_ACTIVATE, new FilterThemeEvent($theme));
        $this->container->get('sylius_theming.manipulator.theme')->enable($theme);
        $this->container->get('sylius_theming.cache')->remove('sylius_theming.themes');
        $this->container->get('sylius_theming.cache')->set('sylius_theming.active_theme', $theme->getLogicalName());
        
        return new RedirectResponse($this->container->get('request')->headers->get('referer'));
    }
    
	/**
     * Enables theme.
     */
    public function enableAction($id)
    {
        $theme = $this->container->get('sylius_theming.manager.theme')->findTheme($id);
        
        if (!$theme) {
            throw new NotFoundHttpException('Requested theme does not exist.');
        }
        
        $this->container->get('event_dispatcher')->dispatch(SyliusThemingEvents::THEME_ENABLE, new FilterThemeEvent($theme));
        $this->container->get('sylius_theming.manipulator.theme')->enable($theme);
        $this->container->get('sylius_theming.cache')->remove('sylius_theming.themes');
        
        return new RedirectResponse($this->container->get('request')->headers->get('referer'));
    }
    
	/**
     * Disables theme.
     */
    public function disableAction($id)
    {
        $theme = $this->container->get('sylius_theming.manager.theme')->findTheme($id);
        
        if (!$theme) {
            throw new NotFoundHttpException('Requested theme does not exist.');
        }
        
        if ($theme->getLogicalName() === $this->container->get('liip_theme.active_theme')->getName()) {
            $this->container->get('sylius_theming.cache')->remove('sylius_theming.active_theme');
        }
        
        $this->container->get('event_dispatcher')->dispatch(SyliusThemingEvents::THEME_DISABLE, new FilterThemeEvent($theme));
        $this->container->get('sylius_theming.manipulator.theme')->disable($theme);
        $this->container->get('sylius_theming.cache')->remove('sylius_theming.themes');
        
        return new RedirectResponse($this->container->get('request')->headers->get('referer'));
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
