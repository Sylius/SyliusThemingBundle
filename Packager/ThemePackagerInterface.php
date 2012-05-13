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
use Sylius\Bundle\ThemingBundle\Packager\Downloader\PackageDownloaderInterface;
use Sylius\Bundle\ThemingBundle\Packager\Extractor\PackageExtractorInterface;

/**
 * Theme packages manager interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface ThemePackageInterface
{
    /**
     * Finds all packages in theming directory.
     *
     * @return array of ThemePackageInterface
     */
    function findPackages();

    /**
     * Find package by given identifier.
     * Extract it if needed.
     *
     * @return ThemePackageInterface
     */
    function findPackage($identifier);

    /**
     * Remove package.
     *
     * @param string|ThemePackageInterface $package Package instance or identifier
     */
    function removePackage($package);

    /**
     * Use one of downloaders to download package.
     *
     * @param string $url
     */
    function downloadPackage($url);

    /**
     * Use one of extractors to extract the package.
     *
     * @param string|ThemePackageInterface $package Package instance or identifier
     */
    function extractPackage($package);

    /**
     * Register downloader.
     *
     * @param PackageDownloaderInterface $downloader
     */
    function registerDownloader(PackageDownloaderInterface $downloader);

    /**
     * Register extractor.
     *
     * @param PackageExtractorInterface $extractor
     */
    function registerExtractor(PackageExtractorInterface $extractor);

    /**
     * Get theming directory.
     *
     * @return string
     */
    function getThemingDir();

    /**
     * Set theming dir.
     *
     * @param string $themingDir
     */
    function setThemingDir($themingDir);
}
