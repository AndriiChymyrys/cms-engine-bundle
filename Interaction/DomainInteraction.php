<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\PageServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Layout\TwigLayoutServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\PageRenderFactoryInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\ContentViewFactoryInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\Available\AvailableContentTypesFactoryInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\Publish\PublishServiceInterface;

/**
 * Class DomainInteraction
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Interaction
 */
class DomainInteraction implements DomainInteractionInterface
{
    /**
     * @param ThemeManagerServiceInterface $themeManagerService
     * @param PageServiceInterface $pageService
     * @param TwigLayoutServiceInterface $twigLayoutService
     * @param AvailableContentTypesFactoryInterface $availableContentTypesFactory
     * @param ContentViewFactoryInterface $contentViewFactory
     * @param PageRenderFactoryInterface $pageRenderFactory
     * @param PublishServiceInterface $publishService
     */
    public function __construct(
        protected ThemeManagerServiceInterface $themeManagerService,
        protected PageServiceInterface $pageService,
        protected TwigLayoutServiceInterface $twigLayoutService,
        protected AvailableContentTypesFactoryInterface $availableContentTypesFactory,
        protected ContentViewFactoryInterface $contentViewFactory,
        protected PageRenderFactoryInterface $pageRenderFactory,
        protected PublishServiceInterface $publishService,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getThemeManagerService(): ThemeManagerServiceInterface
    {
        return $this->themeManagerService;
    }

    /**
     * {@inheritDoc}
     */
    public function getPageService(): PageServiceInterface
    {
        return $this->pageService;
    }

    /**
     * {@inheritDoc}
     */
    public function getTwigLayoutService(): TwigLayoutServiceInterface
    {
        return $this->twigLayoutService;
    }

    /**
     * {@inheritDoc}
     */
    public function getAvailableContentTypesFactory(): AvailableContentTypesFactoryInterface
    {
        return $this->availableContentTypesFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function getContentViewFactory(): ContentViewFactoryInterface
    {
        return $this->contentViewFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function getPageRenderFactory(): PageRenderFactoryInterface
    {
        return $this->pageRenderFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function getPublishService(): PublishServiceInterface
    {
        return $this->publishService;
    }
}
