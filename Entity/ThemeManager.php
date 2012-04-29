<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemingBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sylius\Bundle\ThemingBundle\Model\ThemeInterface;
use Sylius\Bundle\ThemingBundle\Model\ThemeManager as BaseThemeManager;

/**
 * Doctrine ORM driver theme manager.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ThemeManager extends BaseThemeManager
{
    /**
     * Entity manager.
     *
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Theme entity repository.
     *
     * @var EntityRepository
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param EntityManager $entityManager
     * @param string        $class
     */
    public function __construct(EntityManager $entityManager, $class)
    {
        parent::__construct($class);

        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository($this->getClass());
    }

    /**
     * {@inheritdoc}
     */
    public function createTheme()
    {
        $class = $this->getClass();

        return new $class;
    }

    /**
     * {@inheritdoc}
     */
    public function persistTheme(ThemeInterface $product)
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function removeTheme(ThemeInterface $product)
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function findTheme($id)
    {
        return $this->repository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findThemeBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function findThemes()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findThemesBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }
}
