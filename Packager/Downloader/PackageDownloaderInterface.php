<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\Packager\Downloader;

/**
 * Theme package downloader interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface PackageDownloaderInterface
{
    /**
     * Downloads package into theming dir.
     *
     * @param string
     */
    function download($url);

    /**
     * Supports given url?
     *
     * @param string $url
     *
     * @return Boolean
     */
    function supports($url);
}

