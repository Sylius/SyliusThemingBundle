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

use Sylius\Bundle\ThemingBundle\Model\ThemeManagerInterface;
use Sylius\Bundle\ThemingBundle\Model\ThemeInterface;

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
     * Constructor.
     * 
     * @param ThemeManagerInterface 	$themeManager
     * @param SlugizerInterface 		$slugizer
     */
    public function __construct(ThemeManagerInterface $themeManager)
    {
        $this->themeManager = $themeManager;
    }
    
    /**
     * {@inheritdoc}
     */
    public function install(ThemeInterface $theme)
    {
        $theme->incrementInstalledAt();
        $this->themeManager->persistTheme($theme);
    }
    
	/**
     * {@inheritdoc}
     */
    public function uninstall(ThemeInterface $theme)
    {     
        $this->themeManager->removeTheme($theme);
    }
    
    /**
     * {@inheritdoc}
     */
    public function enable(ThemeInterface $theme)
    {
        $theme->setEnabled(true);
        $this->themeManager->persistTheme($theme);
    }
    
   	/**
     * {@inheritdoc}
     */
    public function disable(ThemeInterface $theme)
    {
        $theme->setEnabled(false);
        $this->themeManager->persistTheme($theme);
    }
}
