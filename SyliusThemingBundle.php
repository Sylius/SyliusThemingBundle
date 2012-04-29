<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Rich featured theming for end-user Symfony2 applications.
 * If you need just to theme your app as a developer,
 * please consider using LiipThemeBundle.
 * It is simpler and probably will fit your needs.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SyliusThemingBundle extends Bundle
{
    // Bundle driver list.
    const DRIVER_DOCTRINE_ORM         = 'doctrine/orm';
    const DRIVER_DOCTRINE_MONGODB_ODM = 'doctrine/mongodb-odm';
    const DRIVER_DOCTRINE_COUCHDB_ODM = 'doctrine/couchdb-odm';
    const DRIVER_PROPEL               = 'propel';

    /**
     * Return array with currently supported drivers.
     *
     * @return array
     */
    static public function getSupportedDrivers()
    {
        return array(
            self::DRIVER_DOCTRINE_ORM
        );
    }
}
