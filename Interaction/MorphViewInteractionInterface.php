<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction;

/**
 * Class MorphViewInteractionInterface
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Interaction
 */
interface MorphViewInteractionInterface
{
    /** @var string */
    public const SIDE_BAR_LINK_SERVICE_NAME = 'WideMorph\Morph\Bundle\MorphViewBundle\Infrastructure\Twig\SideBarLink';
}
