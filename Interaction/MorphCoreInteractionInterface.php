<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction;

use WideMorph\Morph\Bundle\MorphCoreBundle\Interaction\DomainInteractionInterface;

/**
 * Class MorphCoreInteractionInterface
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Interaction
 */
interface MorphCoreInteractionInterface
{
    /**
     * @return DomainInteractionInterface
     */
    public function getDomainInteraction(): DomainInteractionInterface;
}
