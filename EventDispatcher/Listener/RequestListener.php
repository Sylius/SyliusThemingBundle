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

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Sylius\Bundle\ThemingBundle\Resolver\DynamicThemeResolver;

/**
 * Listens to the request and changes the active theme based on a cookie.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class RequestListener
{
    protected $resolver;
    
    public function __construct(DynamicThemeResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param GetResponseEvent $event
     */
     public function onKernelRequest(GetResponseEvent $event)
     {
         if(HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
            if(!$event->getRequest()->isXmlHttpRequest()) {
                $this->resolver->setActiveThemeId($event->getRequest()->cookies->get('SYLIUS_THEMING_THEME'));
            }
        }
     }
}
