<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Repository\Cms;

use Doctrine\ORM\EntityRepository;
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

    public function getFieldContent(Field $field): mixed
    {
        $repository = $this->getFieldTypeRepository($field);

        $qb = $repository->createQueryBuilder('v');

        return $qb
            ->where($qb->expr()->eq('v.field', ':fieldId'))
            ->setParameter('fieldId', $field->getId())
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function updateFieldContent(Field $field, mixed $value): void
    {
        $repository = $this->getFieldTypeRepository($field);

        $content = $repository->findOneBy(['field' => $field->getId()]);

        if (!$content) {
            $contentEntityName = $this->getFieldTypeEntityName($field);
            $content = new $contentEntityName();
            $content->setField($field);

            $this->getEntityManager()->persist($content);
        }

        $content->setValue($value);
    }

    protected function getFieldTypeRepository(Field $field): EntityRepository
    {
        return $this
            ->getEntityManager()
            ->getRepository($this->getFieldTypeEntityName($field));
    }

    protected function getFieldTypeEntityName(Field $field): string
    {
        return DatabaseFieldTypeEnum::from($field->getDbType())->getEntityClass();
    }
}
