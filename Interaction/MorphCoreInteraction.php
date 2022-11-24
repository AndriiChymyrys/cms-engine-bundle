<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction;

use WideMorph\Morph\Bundle\MorphCoreBundle\Interaction\DomainInteractionInterface;

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
}
