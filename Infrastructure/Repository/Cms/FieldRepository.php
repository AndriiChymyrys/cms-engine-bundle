<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Repository\Cms;

use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Dto\ContentTypeDto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Field;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\DatabaseFieldTypeEnum;

class FieldRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     * @param string $entityClass
     */
    public function __construct(
        ManagerRegistry $registry,
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

    public function updateFieldContent(Field $field, mixed $value, ContentTypeDto $contentData): void
    {
        $repository = $this->getFieldTypeRepository($field);

        $content = $repository->findOneBy(['field' => $field->getId()]);

        $field->setConfig($contentData->configs)->setOrder($contentData->order);

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
