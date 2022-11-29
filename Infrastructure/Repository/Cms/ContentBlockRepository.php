<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Repository\Cms;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\ContentBlock;

class ContentBlockRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     * @param string $entityClass
     */
    public function __construct(
        ManagerRegistry $registry,
        string $entityClass = ContentBlock::class
    ) {
        parent::__construct($registry, $entityClass);
    }

    public function getPageBlockByName(Page $page, string $blockName)
    {
        $qb = $this->createQueryBuilder('cb');

        return $qb
            ->where($qb->expr()->eq('cb.name', ':name'))
            ->andWhere($qb->expr()->eq('cb.theme', ':theme'))
            ->andWhere($qb->expr()->eq('cb.layout', ':layout'))
            ->setParameter('name', $blockName)
            ->setParameter('theme', $page->getTheme())
            ->setParameter('layout', $page->getLayout())
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getPageBlocksByLayoutAndTheme(string $layout, string $theme): array
    {
        $qb = $this->createQueryBuilder('cb');

        return $qb
            ->where($qb->expr()->eq('cb.theme', ':theme'))
            ->andWhere($qb->expr()->eq('cb.layout', ':layout'))
            ->setParameter('theme', $theme)
            ->setParameter('layout', $layout)
            ->getQuery()
            ->getResult();
    }
}
