<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\DataSource;

use App\Entity\Cms\Page;
use Doctrine\ORM\EntityManagerInterface;
use WideMorph\Morph\Bundle\MorphCoreBundle\Domain\Services\Input\InputDataCollectionInterface;
use WideMorph\Morph\Bundle\MorphCoreBundle\Interaction\Contract\DataSource\SelectDataSourceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Bridge\MorphCore\SelectDataSourceDefinitionInterfaceBridge;

/**
 * Class SelectPageDataSource
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Domain\DataSource
 */
class SelectPageDataSource implements SelectDataSourceDefinitionInterfaceBridge
{
    /** @var int */
    public const PER_PAGE = 20;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        protected EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getSource(): SelectDataSourceInterface
    {
        return $this->entityManager->getRepository(Page::class);
    }

    /**
     * {@inheritDoc}
     */
    public function getSourcePagination(InputDataCollectionInterface $inputDataCollection): ?array
    {
        $page = $inputDataCollection->containsKey('page') ? $inputDataCollection->get('page') : 1;

        return [$page, static::PER_PAGE];
    }
}
