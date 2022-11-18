<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Repository\Cms;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\MorphCoreInteractionInterface;
use WideMorph\Morph\Bundle\MorphCoreBundle\Domain\Services\Input\InputDataCollectionInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Bridge\MorphCore\SelectDataSourceInterfaceBridge;

/**
 * Class PageRepository
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Repository\Cms
 */
class PageRepository extends ServiceEntityRepository implements SelectDataSourceInterfaceBridge
{
    /** @var string */
    public const CONTEXT_NAME_SELECT_PAGE = 'cms.select.page';

    /**
     * @param ManagerRegistry $registry
     * @param MorphCoreInteractionInterface $morphCoreInteraction
     * @param string $entityClass
     */
    public function __construct(
        ManagerRegistry $registry,
        protected MorphCoreInteractionInterface $morphCoreInteraction,
        string $entityClass = Page::class
    ) {
        parent::__construct($registry, $entityClass);
    }

    /**
     * {@inheritDoc}
     */
    public function select(InputDataCollectionInterface $inputDataCollection, ?array $pagination = null): mixed
    {
        $queryContext = $this->morphCoreInteraction
            ->getDomainInteraction()
            ->getDoctrineDataFilterContextFactory()
            ->forQueryBuilder(
                $this->createQueryBuilder('p'),
                static::CONTEXT_NAME_SELECT_PAGE,
                true
            );

        [$page, $repPage] = $pagination;

        return $queryContext->execute()->setPagination($page, $repPage)->getResult();
    }
}
