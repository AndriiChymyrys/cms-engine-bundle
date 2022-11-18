<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\PageServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Layout\TwigLayoutServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;

class DomainInteraction implements DomainInteractionInterface
{
    public function __construct(
        protected ThemeManagerServiceInterface $themeManagerService,
        protected PageServiceInterface $pageService,
        protected TwigLayoutServiceInterface $twigLayoutService,
    ) {
    }

    public function getThemeManagerService(): ThemeManagerServiceInterface
    {
        return $this->themeManagerService;
    }

    public function getPageService(): PageServiceInterface
    {
        return $this->pageService;
    }

    public function getTwigLayoutService(): TwigLayoutServiceInterface
    {
        return $this->twigLayoutService;
    }
}
