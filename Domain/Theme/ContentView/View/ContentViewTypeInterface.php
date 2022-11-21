<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\View;

use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;

interface ContentViewTypeInterface
{
    public function getEditView(
        Page $page,
        string $contentBlock,
        string $content,
        string $contentKey
    ): string;

    public function getPageView(): string;
}
