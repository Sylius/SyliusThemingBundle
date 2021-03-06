<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\Manipulator;

use Sylius\Bundle\ThemingBundle\Cache\CacheInterface;
use Sylius\Bundle\ThemingBundle\Model\ThemeInterface;
use Sylius\Bundle\ThemingBundle\Model\ThemeManagerInterface;

/**
 * Theme manipulator.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ThemeManipulator implements ThemeManipulatorInterface
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
     * Constructor.
     *
     * @param ThemeManagerInterface $themeManager
     * @param CacheInterface     $cache
     */
    public function __construct(ThemeManagerInterface $themeManager, CacheInterface $cache)
    {
        $this->themeManager = $themeManager;
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function install(ThemeInterface $theme)
    {
        $this->themeManager->persistTheme($theme);
        $this->cache->remove('installed');
    }

    /**
     * {@inheritdoc}
     */
    public function uninstall(ThemeInterface $theme)
    {
        $this->themeManager->removeTheme($theme);
        $this->cache->remove('installed');
    }

    /**
     * {@inheritdoc}
     */
    public function enable(ThemeInterface $theme)
    {
        $theme->setEnabled(true);
        $this->themeManager->persistTheme($theme);
        $this->cache->remove('installed');
    }

    /**
     * {@inheritdoc}
     */
    public function disable(ThemeInterface $theme)
    {
        $theme->setEnabled(false);
        $this->themeManager->persistTheme($theme);
        $this->cache->remove('installed');
    }
}
