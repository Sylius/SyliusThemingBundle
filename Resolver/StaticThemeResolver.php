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
use Sylius\Bundle\ThemingBundle\Cache\CacheInterface;
use Sylius\Bundle\ThemingBundle\Model\ThemeManagerInterface;

/**
 * Static theming, configured through webinterface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class StaticThemeResolver implements ThemeResolverInterface
{
    /**
     * @var ThemeInterface
     */
    protected $activeTheme;
    
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
    
    public function resolveActiveTheme()
    {
        if (null == $this->activeTheme && $this->cache->has('sylius_theming.theme')) {
            $this->activeTheme = $this->cache->get('sylius_theming.theme');
        }
        
        return $this->activeTheme;
    }
    
    public function setActiveTheme(ThemeInterface $theme)
    {
        $this->cache->set('sylius_theming.theme', $theme);
        $this->activeTheme = $theme;
    }
}
