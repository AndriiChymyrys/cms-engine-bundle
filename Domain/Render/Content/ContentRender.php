<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\Content;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\PageRenderInterface;

class ContentRender implements ContentRenderInterface
{
    public function hasContent(string $blockName, string $contentName, PageRenderInterface $pageRender): bool
    {
        return false;
    }

    public function getContent(string $blockName, string $contentName, PageRenderInterface $pageRender): string
    {
        return 'testString';
    }
}
