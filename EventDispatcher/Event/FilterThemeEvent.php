<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;
use Sylius\Bundle\ThemingBundle\Model\ThemeInterface;

/**
 * Theme filter event.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class FilterThemeEvent extends Event
{
    /**
     * Theme.
     * 
     * @var ThemeInterface
     */
    protected $theme;
    
    public function __construct(ThemeInterface $theme)
    {
        $this->theme = $theme;
    }
    
    public function getTheme()
    {
        return $this->theme;
    }
}
