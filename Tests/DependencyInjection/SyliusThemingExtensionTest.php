<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\Tests\DependencyInjection;

use Sylius\Bundle\ThemingBundle\DependencyInjection\SyliusThemingExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

/**
 * Dependency injection container extension test.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SyliusThemingExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessDriverSet()
    {
        $loader = new SyliusThemingExtension();
        $config = $this->getEmptyConfig();
        unset($config['driver']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * getEmptyConfig
     *
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml =
<<<EOF
    driver: ORM
    classes:
        model:
            theme: Sylius\Bundle\ThemingBundle\Entity\Theme
EOF;

        $parser = new Parser();

        return $parser->parse($yaml);
    }
}
