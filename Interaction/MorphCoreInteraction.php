<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction;

use WideMorph\Cms\Bundle\CmsEngineBundle\CmsEngineBundle;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\DatabaseFieldTypeEnum;
use WideMorph\Morph\Bundle\MorphCoreBundle\Interaction\DomainInteractionInterface;
use WideMorph\Morph\Bundle\MorphCoreBundle\Domain\Services\Entity\EntityResolverInterface;

/**
 * Class MorphCoreInteraction
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Interaction
 */
class MorphCoreInteraction implements MorphCoreInteractionInterface
{
    /**
     * @param DomainInteractionInterface $domainInteraction
     */
    public function __construct(protected DomainInteractionInterface $domainInteraction)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getDomainInteraction(): DomainInteractionInterface
    {
        return $this->domainInteraction;
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityResolver(): EntityResolverInterface
    {
        return $this->domainInteraction
            ->getEntityResolverFactory()
            ->forBundle(CmsEngineBundle::class)
            ->attachEntity('Cms/Page')
            ->attachEntity('Cms/Field')
            ->attachEntity('Cms/Content')
            ->attachEntity('Cms/ContentType')
            ->attachEntity('Cms/ContentBlock')
            ->attachEntity(DatabaseFieldTypeEnum::DATETIME->getEntityResolverName())
            ->attachEntity(DatabaseFieldTypeEnum::INTEGER->getEntityResolverName())
            ->attachEntity(DatabaseFieldTypeEnum::JSON->getEntityResolverName())
            ->attachEntity(DatabaseFieldTypeEnum::STRING->getEntityResolverName())
            ->attachEntity(DatabaseFieldTypeEnum::TEXT->getEntityResolverName())
            ->get();
    }
}
