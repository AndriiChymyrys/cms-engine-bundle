<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\Content;

use Generator;
use App\Entity\Cms\Content;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\PageRenderInterface;

/**
 * Class ContentRenderInterface
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\Content
 */
interface ContentRenderInterface
{
    /**
     * @param string $blockName
     * @param string $contentName
     * @param PageRenderInterface $pageRender
     *
     * @return Content|null
     */
    public function getContent(string $blockName, string $contentName, PageRenderInterface $pageRender): ?Content;

    /**
     * @param Content $content
     * @param PageRenderInterface $pageRender
     *
     * @return Generator
     */
    public function renderTypes(Content $content, PageRenderInterface $pageRender): Generator;
}
