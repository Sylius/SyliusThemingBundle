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

use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Sylius\Bundle\ThemingBundle\Model\ThemeInterface;
use Sylius\Bundle\ThemingBundle\Cache\CacheInterface;
use Sylius\Bundle\ThemingBundle\Model\ThemeManagerInterface;

/**
 * Provides all enabled themes and active theme.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class DynamicThemeResolver implements ThemeResolverInterface
{    
    /**
     * @var ThemeInterface
     */
    protected $activeTheme;
    
    /**
     * @var integer
     */
    protected $activeThemeId;
    
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
     * @param Request				$request
     */
    public function __construct(ThemeManagerInterface $themeManager, CacheInterface $cache)
    {
        $this->themeManager = $themeManager;
        $this->cache = $cache;
    }
    
    public function setActiveThemeId($activeThemeId)
    {
        $this->activeThemeId = $activeThemeId;
    }
    
    public function resolveActiveTheme()
    {
        if ($this->activeThemeId === null) {
            return null;
        }
        
        $activeThemeId = $this->activeThemeId;
        
        if (null === $this->activeTheme) {
            if (null !== $this->activeTheme = $this->cache->get('sylius_theming.theme.' . $activeThemeId)) {
                $this->activeTheme = $this->themeManager->findTheme($activeThemeId);
                
                if(!$this->activeTheme) {
                    throw new RuntimeException('Invalid theme id supplied in cookie.');
                }
                
                $this->cache->set('sylius_theming.theme.' . $activeThemeId, $this->activeTheme);
            }
        }
        
        return $this->activeTheme;
    }
    
    public function setActiveTheme(ThemeInterface $theme)
    {
        $this->activeTheme = $theme;
    }
}
