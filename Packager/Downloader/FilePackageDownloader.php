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
 * Theme package downloader that loads remote files.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class FilePackageDownloader implements PackageDownloaderInterface
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
