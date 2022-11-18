<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\PageServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Layout\TwigLayoutServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\AvailableContentFactoryInterface;

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
     * @param AvailableContentFactoryInterface $availableContentFactory
     */
    public function __construct(
        protected ThemeManagerServiceInterface $themeManagerService,
        protected PageServiceInterface $pageService,
        protected TwigLayoutServiceInterface $twigLayoutService,
        protected AvailableContentFactoryInterface $availableContentFactory,
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
    public function getAvailableContentFactory(): AvailableContentFactoryInterface
    {
        return $this->availableContentFactory;
    }
}
