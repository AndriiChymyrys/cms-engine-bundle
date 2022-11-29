<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\RouteParameterEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\Assets\AssetsRenderFactoryInterface;

class PageRenderFactory implements PageRenderFactoryInterface
{
    /**
     * @param PageRenderInterface $pageRender
     * @param AssetsRenderFactoryInterface $assetsRenderFactory
     */
    public function __construct(
        protected PageRenderInterface $pageRender,
        protected AssetsRenderFactoryInterface $assetsRenderFactory
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getPageRender(array $attributes): PageRenderInterface
    {
        $page = $attributes[RouteParameterEnum::PAGE->value];

        return $this->pageRender->init($page, $this->assetsRenderFactory->getAssetRender($page), $attributes);
    }
}
