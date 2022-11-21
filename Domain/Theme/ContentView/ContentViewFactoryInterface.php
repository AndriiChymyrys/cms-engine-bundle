<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\ContentTypeEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\View\ContentViewTypeInterface;

interface ContentViewFactoryInterface
{
    public function getContentView(
        Page $page,
        ContentTypeEnum $contentType,
    ): ContentViewTypeInterface;
}
