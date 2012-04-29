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

use Sylius\Bundle\ThemingBundle\Resolver\ThemeResolverInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Listens to the request and changes the active theme based on a cookie.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class RequestListener
{
    /**
     * Theme resolver.
     *
     * @var ThemeResolverInterface
     */
    protected $resolver;

    /**
     * Constructor.
     *
     * @param ThemeResolverInterface $resolver
     */
    public function __construct(ThemeResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Resolve theme for current user.
     *
     * @param GetResponseEvent $event
     */
     public function onKernelRequest(GetResponseEvent $event)
     {
         $this->resolver->resolveActiveTheme($event->getRequest());
     }
}
