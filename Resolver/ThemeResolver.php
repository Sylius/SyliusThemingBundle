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

use Liip\ThemeBundle\ActiveTheme;
use Sylius\Bundle\ThemingBundle\Cache\CacheInterface;
use Sylius\Bundle\ThemingBundle\Model\ThemeManagerInterface;

/**
 * Static theming, configured through webinterface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ThemeResolver implements ThemeResolverInterface
{
    /**
     * Theme manager.
     * 
     * @var ThemeManagerInterface
     */
    protected $themeManager;
    
    /**
     * Cache.
     * 
     * @var CacheInterface
     */
    protected $cache;
    
    /**
     * @param ThemeManagerInterface $themeManager
     * @param CacheInterface		$cache
     */
    public function __construct(ThemeManagerInterface $themeManager, CacheInterface $cache)
    {
        $this->themeManager = $themeManager;
        $this->cache = $cache;
    }
    
    public function resolveActiveTheme(ActiveTheme $activeTheme)
    {
        if ($this->cache->has('sylius_theming.themes')) {
            $activeTheme->setThemes($this->cache->get('sylius_theming.themes'));
        } else {
            $themes = $this->themeManager->findThemesBy(array('enabled' => true));
            $themesLogicalNames = array();
            
            foreach ($themes as $theme) {
                $themesLogicalNames[] = $theme->getLogicalName();
            }
            
            $this->cache->set('sylius_theming.themes', $themesLogicalNames);
            $activeTheme->setThemes($themesLogicalNames);
        
        }

        if (null == $activeTheme->getName() && $this->cache->has('sylius_theming.active_theme')) {
            $activeTheme->setName($this->cache->get('sylius_theming.active_theme'));
        }
    }
}
