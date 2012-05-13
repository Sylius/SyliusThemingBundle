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
class ThemePackager implements ThemePackagerInterface
{
    /**
     * Directory where themes are stored.
     *
     * @var string
     */
    protected $themingDir;

    /**
     * Extractors.
     *
     * @var array Array of PackageExtractorInterface
     */
    protected $extractors;

    /**
     * Downloaders.
     *
     * @var array Array of PackageDownloaderInterface
     */
    protected $downloaders;

    /**
     * @param string $themingDir
     */
    public function __construct($themingDir)
    {
        $this->themingdir = $themingDir;
    }

    /**
     * {@inheritdoc}
     */
    public function findPackages()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function findPackage($id)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function removePackage($package)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function downloadPackage($url)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function extractPackage($package)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function registerDownloader(PackageDownloaderInterface $downloader)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function registerExtractor(PackageExtractorInterface $extractor)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getThemingDir()
    {
        return $this->themingDir;
    }

    /**
     * {@inheritdoc}
     */
    public function setThemingDir($themingDir)
    {
        $this->themingDir = $themingDir;
    }
}
