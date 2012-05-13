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
 * Theme package downloader that loads packages from git repositories.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class GitPackageDownloader implements PackageDownloaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function download($url)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function supports($url)
    {
    }
}
