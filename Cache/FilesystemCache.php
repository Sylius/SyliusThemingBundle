<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\Cache;

/**
 * Filesystem cache.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class FilesystemCache implements CacheInterface
{
    private $dir;

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    public function has($key)
    {
        return file_exists($this->dir.'/'.$key);
    }

    public function get($key)
    {
        $path = $this->dir.'/'.$key;

        if (!file_exists($path)) {
            throw new \RuntimeException(sprintf('Unable to load cache file "%s".', $path));
        }

        return unserialize(file_get_contents($path));
    }

    public function set($key, $value)
    {
        if (!is_dir($this->dir) && false === @mkdir($this->dir, 0777, true)) {
            throw new \RuntimeException(sprintf('Unable to open or create cache dir "%s".', $this->dir));
        }

        $path = $this->dir.'/'.$key;

        if (false === @file_put_contents($path, serialize($value))) {
            throw new \RuntimeException(sprintf('Unable to write cache file "%s".', $path));
        }
    }

    public function remove($key)
    {
        $path = $this->dir.'/'.$key;

        if (file_exists($path) && false === @unlink($path)) {
            throw new \RuntimeException(sprintf('Unable to remove cache file "%s".', $path));
        }
    }
}
