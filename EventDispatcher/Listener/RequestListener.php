<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\EventDispatcher\Listener;

use Liip\ThemeBundle\ActiveTheme;
use Sylius\Bundle\ThemingBundle\Resolver\ThemeResolverInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Listens to the request and changes the active theme based on a cookie.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class RequestListener
{
    protected $resolver;
    
    public function __construct(ThemeResolverInterface $resolver, ActiveTheme $activeTheme)
    {
        $this->resolver = $resolver;
        $this->activeTheme = $activeTheme;
    }

    /**
     * @param GetResponseEvent $event
     */
     public function onKernelRequest(GetResponseEvent $event)
     {
         $this->resolver->resolveActiveTheme($this->activeTheme);
     }
}
