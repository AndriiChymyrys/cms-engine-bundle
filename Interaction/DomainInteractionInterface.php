<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\PageServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Layout\TwigLayoutServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\PageRenderFactoryInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\ContentViewFactoryInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\Available\AvailableContentTypesFactoryInterface;

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
     * @return AvailableContentTypesFactoryInterface
     */
    public function getAvailableContentTypesFactory(): AvailableContentTypesFactoryInterface;

    /**
     * @return ContentViewFactoryInterface
     */
    public function getContentViewFactory(): ContentViewFactoryInterface;

    /**
     * @return PageRenderFactoryInterface
     */
    public function getPageRenderFactory(): PageRenderFactoryInterface;
}
