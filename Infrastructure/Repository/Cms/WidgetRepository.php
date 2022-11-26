<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Repository\Cms;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Widget;

class WidgetRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     * @param string $entityClass
     */
    public function __construct(
        ManagerRegistry $registry,
        string $entityClass = Widget::class
    ) {
        parent::__construct($registry, $entityClass);
    }
}
