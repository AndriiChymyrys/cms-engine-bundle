<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render;

interface PageRenderFactoryInterface
{
    /**
     * @param array $attributes
     *
     * @return PageRenderInterface
     */
    public function getPageRender(array $attributes): PageRenderInterface;
}
