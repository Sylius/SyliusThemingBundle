<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\Model;

/**
 * Base class for theme model.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
abstract class Theme implements ThemeInterface
{
    protected $id;
    protected $name;
    protected $version;
    protected $description;
    protected $rootDir;
    protected $enabled;
    protected $installedAt;
    
    public function __construct()
    {
        $this->enabled = false;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getVersion()
    {
        return $this->version;
    }
    
    public function setVersion($version)
    {
        $this->version = $version;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function getRootDir()
    {
        return $this->rootDir;
    }
    
    public function setRootDir($rootDir)
    {
        $this->rootDir = $rootDir;
    }
    
    public function isEnabled()
    {
        return $this->enabled;
    }
    
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
    
    public function getInstalledAt()
    {
        return $this->installedAt;
    }
    
    public function incrementInstalledAt()
    {
        if (null == $this->installedAt) {
            $this->installedAt = new \DateTime;
        }
    }
    
    public function loadConfiguration(array $configuration)
    {
        $this->setName($configuration['name']);
        $this->setVersion($configuration['version']);
        $this->setDescription($configuration['description']);
    }
}
