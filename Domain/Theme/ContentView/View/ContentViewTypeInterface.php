<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\View;

use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\FieldProviderInterface;

interface ContentViewTypeInterface
{
    public function getEditView(
        Page $page,
        string $contentKey,
        bool $asProvider = false
    ): FieldProviderInterface|string;

    public function getPageView(Page $page, string $contentKey, bool $asProvider = false): FieldProviderInterface|string;
}
