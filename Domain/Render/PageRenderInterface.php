<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render;

use App\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\Assets\AssetsRenderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\ThemeProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\LayoutProviderInterface;

interface PageRenderInterface
{
    /**
     * @return string
     */
    public function getLayoutName(): string;

    /**
     * @return ThemeProviderInterface
     */
    public function getThemeProvider(): ThemeProviderInterface;

    /**
     * @return LayoutProviderInterface
     */
    public function getLayoutProvider(): LayoutProviderInterface;

    /**
     * @param string $assetName
     *
     * @return string
     */
    public function getAsset(string $assetName): string;

    /**
     * @return Page
     */
    public function getPage(): Page;

    /**
     * @param Page $page
     * @param AssetsRenderInterface $assetsRender
     * @param array $attributes
     *
     * @return $this
     */
    public function init(Page $page, AssetsRenderInterface $assetsRender, array $attributes): self;

    /**
     * @return AssetsRenderInterface
     */
    public function getContentTypeAssets(): AssetsRenderInterface;
}
