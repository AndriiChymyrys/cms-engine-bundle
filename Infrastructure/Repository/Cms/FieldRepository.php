<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Repository\Cms;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Field;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\DatabaseFieldTypeEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\MorphCoreInteractionInterface;

class FieldRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     * @param MorphCoreInteractionInterface $morphCoreInteraction
     * @param string $entityClass
     */
    public function __construct(
        ManagerRegistry $registry,
        protected MorphCoreInteractionInterface $morphCoreInteraction,
        string $entityClass = Field::class
    ) {
        parent::__construct($registry, $entityClass);
    }

    public function getFieldContentType(int $pageId, string $contentBlock, string $content, string $theme, string $type)
    {
        $qb = $this->createQueryBuilder('f');

        return $qb
            ->join('f.content', 'c')
            ->join(
                'c.contentBlock',
                'cb',
                Join::WITH,
                $qb->expr()->eq('cb.page', ':pageId')
            )
            ->where($qb->expr()->eq('cb.name', ':name'))
            ->andWhere($qb->expr()->eq('c.name', ':content'))
            ->andWhere($qb->expr()->eq('f.theme', ':theme'))
            ->andWhere($qb->expr()->eq('f.type', ':type'))
            ->setParameter('name', $contentBlock)
            ->setParameter('pageId', $pageId)
            ->setParameter('content', $content)
            ->setParameter('type', $type)
            ->setParameter('theme', $theme)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getFieldContent(Field $field): mixed
    {
        $dbType = DatabaseFieldTypeEnum::from($field->getDbType());
        $entityResolver = $this->morphCoreInteraction->getEntityResolver();

        $repository = $entityResolver
            ->getEntityRepository(
                $entityResolver->getEntityName($dbType->getEntityResolverName())
            );

        $qb = $repository->createQueryBuilder('v');

        return $qb
            ->where($qb->expr()->eq('v.field', ':fieldId'))
            ->setParameter('fieldId', $field->getId())
            ->getQuery()
            ->getOneOrNullResult();
    }
}
