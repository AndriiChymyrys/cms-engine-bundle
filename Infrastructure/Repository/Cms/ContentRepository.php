<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Repository\Cms;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Content;

class ContentRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     * @param string $entityClass
     */
    public function __construct(
        ManagerRegistry $registry,
        string $entityClass = Content::class
    ) {
        parent::__construct($registry, $entityClass);
    }

    public function getContentBy(int $pageId, string $blockName, string $contentName): ?Content
    {
        $qb = $this->createQueryBuilder('c');

        return $qb
            ->join('c.contentBlock', 'cb')
            ->where($qb->expr()->eq('cb.name', ':blockName'))
            ->andWhere($qb->expr()->eq('cb.page', ':pageId'))
            ->andWhere($qb->expr()->eq('c.name', ':contentName'))
            ->setParameter('pageId', $pageId)
            ->setParameter('blockName', $blockName)
            ->setParameter('contentName', $contentName)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
