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
use Symfony\Component\Yaml\Yaml;

final class ThemePack
{
    private $path;
    private $name;
    private $configuration;
    private $rootDir;
    
    public function __construct($path)
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentException(sprintf('Theme file does not exist. Looked into... "%s".', $path));
        }
        
        $this->path = $path;
        $this->name = basename($path);
    }
    
    public function getPath()
    {
        return $this->path;
    }
    
    public function getEncodedPath()
    {
        return base64_encode($this->path);
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getConfiguration()
    {   
        if (null == $this->configuration && file_exists($configFile = $this->getPath() . '/theme.yml')) {
            $this->configuration = Yaml::parse(file_get_contents($configFile));
        }
        
        return $this->configuration;
    }
    
    public function buildTheme(ThemeInterface $theme)
    {
        $theme->loadConfiguration($this->getConfiguration());
        $theme->setLogicalName($this->getName());
        
        return $theme;
    }
}
