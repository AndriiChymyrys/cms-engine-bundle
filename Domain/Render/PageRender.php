<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render;

use App\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\Assets\AssetsRenderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\ThemeProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\LayoutProviderInterface;

class PageRender implements PageRenderInterface
{
    /**
     * @var Page
     */
    protected Page $page;

    /**
     * @var array
     */
    protected array $pageData;

    /**
     * @var LayoutProviderInterface
     */
    protected LayoutProviderInterface $layoutProvider;

    /**
     * @var ThemeProviderInterface
     */
    protected ThemeProviderInterface $themeProvider;

    /**
     * @var AssetsRenderInterface
     */
    protected AssetsRenderInterface $assetsRender;

    /**
     * @param ThemeManagerServiceInterface $themeManagerService
     */
    public function __construct(protected ThemeManagerServiceInterface $themeManagerService)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function init(Page $page, AssetsRenderInterface $assetsRender, array $attributes): self
    {
        $this->pageData = $attributes;

        $this->page = $page;

        $this->assetsRender = $assetsRender;

        $this->themeProvider = $this->themeManagerService
            ->getThemeProviderByName($this->page->getTheme());

        $this->layoutProvider = $this->themeManagerService
            ->getThemeLayoutProvider($this->themeProvider, $this->page->getLayout());

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLayoutName(): string
    {
        return $this->layoutProvider->getTemplatePath();
    }

    /**
     * {@inheritDoc}
     */
    public function getThemeProvider(): ThemeProviderInterface
    {
        return $this->themeProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function getLayoutProvider(): LayoutProviderInterface
    {
        return $this->layoutProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function getAsset(string $assetName): string
    {
        return $this->layoutProvider->getAssetPath($assetName);
    }

    /**
     * {@inheritDoc}
     */
    public function getPage(): Page
    {
        return $this->page;
    }

    /**
     * {@inheritDoc}
     */
    public function getContentTypeAssets(): AssetsRenderInterface
    {
        return $this->assetsRender;
    }
}
