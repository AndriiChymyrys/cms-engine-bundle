<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\PageServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Layout\TwigLayoutServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;

interface DomainInteractionInterface
{
    public function getThemeManagerService(): ThemeManagerServiceInterface;

    public function getPageService(): PageServiceInterface;

    public function getTwigLayoutService(): TwigLayoutServiceInterface;
}
