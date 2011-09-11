<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\Locator;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Config\FileLocator as BaseFileLocator;
use Sylius\Bundle\ThemingBundle\Resolver\ThemeResolverInterface;

/**
 * File locator.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class FileLocator extends BaseFileLocator
{
    protected $kernel;
    protected $resolver;

    /**
     * Constructor.
     *
     * @param KernelInterface $kernel A KernelInterface instance
     */
    public function __construct(KernelInterface $kernel, ThemeResolverInterface $resolver)
    {
        $this->kernel = $kernel;
        $this->resolver = $resolver;
    }
    
    /**
     * Returns the file path for a given resource for the first directory it
     * has a match.
     *
     * The resource name must follow the following pattern:
     *
     *     @BundleName/path/to/a/file.something
     *
     * where BundleName is the name of the bundle
     * and the remaining part is the relative path in the bundle.
     *
     * @param string  $name  A resource name to locate
     * @param string  $dir   A directory where to look for the resource first
     * @param Boolean $first Whether to return the first path or paths for all matching bundles
     *
     * @return string|array The absolute path of the resource or an array if $first is false
     *
     * @throws \InvalidArgumentException if the file cannot be found or the name is not valid
     * @throws \RuntimeException         if the name contains invalid/unsafe characters
     */
    public function locate($name, $dir = null, $first = true)
    {
        if ('@' === $name[0]) {
            return $this->locateResource($name, $dir . 'Resources', $first);
        }

        return parent::locate($name, $dir, $first);
    }

    /**
     * Locate resource.
     *
     * Method inlined from Symfony\Component\Http\Kernel.
     *
     * @param string $name
     * @param string $dir
     * @param bool $first
     * @return string
     */
    public function locateResource($name, $dir = null, $first = true)
    {
        if ('@' !== $name[0]) {
            throw new \InvalidArgumentException(sprintf('A resource name must start with @ ("%s" given).', $name));
        }

        if (false !== strpos($name, '..')) {
            throw new \RuntimeException(sprintf('File name "%s" contains invalid characters (..).', $name));
        }

        $bundleName = substr($name, 1);
        $path = '';
        if (false !== strpos($bundleName, '/')) {
            list($bundleName, $path) = explode('/', $bundleName, 2);
        }

        $isResource = 0 === strpos($path, 'Resources') && null !== $dir;
        $overridePath = substr($path, 9);
        $resourceBundle = null;
        $bundles = $this->kernel->getBundle($bundleName, false);
        $files = array();

        foreach ($bundles as $bundle) {
            if ($isResource && file_exists($file = $dir.'/'.$bundle->getName().$overridePath)) {
                if (null !== $resourceBundle) {
                    throw new \RuntimeException(sprintf('"%s" resource is hidden by a resource from the "%s" derived bundle. Create a "%s" file to override the bundle resource.',
                        $file,
                        $resourceBundle,
                        $dir.'/'.$bundles[0]->getName().$overridePath
                    ));
                }

                if ($first) {
                    return $file;
                }
                $files[] = $file;
            }

            if ($this->resolver->resolveActiveTheme()) {
                if (file_exists($file = $this->resolver->resolveActiveTheme()->getRootDir() . '/' . $bundle->getName().'/'.$path)) {
                    
                    if ($first && !$isResource) {
                        return $file;
                    }
                    $files[] = $file;
                    $resourceBundle = $bundle->getName();
                }
            }
            
            if (file_exists($file = $bundle->getPath().'/'.$path)) {
                if ($first && !$isResource) {
                    return $file;
                }
                $files[] = $file;
                $resourceBundle = $bundle->getName();
            }
        }

        if (count($files) > 0) {
            return $first && $isResource ? $files[0] : $files;
        }
        
        throw new \InvalidArgumentException(sprintf('Unable to find file "%s".', $name));
    }
}
