<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\PageServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Layout\TwigLayoutServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\AvailableContentFactoryInterface;

/**
 * Class DomainInteractionInterface
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Interaction
 */
interface DomainInteractionInterface
{
    /**
     * @return ThemeManagerServiceInterface
     */
    public function getThemeManagerService(): ThemeManagerServiceInterface;

    /**
     * @return PageServiceInterface
     */
    public function getPageService(): PageServiceInterface;

    /**
     * @return TwigLayoutServiceInterface
     */
    public function getTwigLayoutService(): TwigLayoutServiceInterface;

    /**
     * @return AvailableContentFactoryInterface
     */
    public function getAvailableContentFactory(): AvailableContentFactoryInterface;
}
