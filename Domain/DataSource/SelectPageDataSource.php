<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\DataSource;

use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\MorphCoreInteractionInterface;
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
     * @param MorphCoreInteractionInterface $morphCoreInteraction
     */
    public function __construct(
        protected MorphCoreInteractionInterface $morphCoreInteraction
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getSource(): SelectDataSourceInterface
    {
        return $this->morphCoreInteraction->getEntityResolver()->getEntityRepository('Cms/Page');
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
