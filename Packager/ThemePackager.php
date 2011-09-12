<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\Packager;

use Sylius\Bundle\ThemingBundle\Model\ThemeInterface;
use Symfony\Component\Finder\Finder;

/**
 * Theme packs management.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ThemePackager
{
    /**
     * Directory where themes are stored.
     * 
     * @var string
     */
    protected $packsDir;
    
    /**
     * @param string $packsDir
     */
    public function __construct($packsDir)
    {
        $this->packsDir = $packsDir;
    }
    
    /**
     * Returns all theme packs that were not installed.
     * 
     * @param array $themes
     */
    public function findPacks(array $themes)
    {
        $finder = new Finder();
        $packsIterator = $finder->directories()->depth(0)->in($this->packsDir)->getIterator();
        
        $packs = array();
        $installedThemesPaths = array();
        
        foreach ($themes as $theme) {
            if (!$theme instanceof ThemeInterface) {
                throw new InvalidArgumentException('Themes supplied to packages must implement Sylius\Bundle\ThemingBundle\Model\ThemeInterface');
            }
            
            $installedThemesPaths[] = $this->packsDir . '/' . $theme->getLogicalName();
        }
        
        foreach ($packsIterator as $path) {
            if (!in_array($path, $installedThemesPaths)) {
                $packs[] = $this->createPack($path);
            }
        }
        
        return $packs;
    }
    
    /**
     * Returns theme pack instance based on path.
     * 
     * @param string $path
     */
    public function createPack($path)
    {
        return new ThemePack($path);
    }
}