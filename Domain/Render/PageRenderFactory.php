<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render;

class PageRenderFactory implements PageRenderFactoryInterface
{
    /**
     * @param PageRenderInterface $pageRender
     */
    public function __construct(protected PageRenderInterface $pageRender)
    {
    }

    public function getPageRender(array $attributes): PageRenderInterface
    {
        return $this->pageRender->init($attributes);
    }
}
