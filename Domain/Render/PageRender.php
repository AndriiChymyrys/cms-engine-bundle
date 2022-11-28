<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render;

use App\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\RouteParameterEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\ThemeProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\LayoutProviderInterface;

class PageRender implements PageRenderInterface
{
    protected Page $page;

    protected array $pageData;

    protected LayoutProviderInterface $layoutProvider;

    protected ThemeProviderInterface $themeProvider;

    public function __construct(protected ThemeManagerServiceInterface $themeManagerService)
    {
    }

    public function init(array $attributes): self
    {
        $this->pageData = $attributes;

        $this->page = $this->pageData[RouteParameterEnum::PAGE->value];

        $this->themeProvider = $this->themeManagerService
            ->getThemeProviderByName($this->page->getTheme());

        $this->layoutProvider = $this->themeManagerService
            ->getThemeLayoutProvider($this->themeProvider, $this->page->getLayout());

        return $this;
    }

    public function getLayoutName(): string
    {
        return $this->layoutProvider->getTemplatePath();
    }

    public function getThemeProvider(): ThemeProviderInterface
    {
        return $this->themeProvider;
    }

    public function getLayoutProvider(): LayoutProviderInterface
    {
        return $this->layoutProvider;
    }

    public function getAsset(string $assetName): string
    {
        return $this->layoutProvider->getAssetPath($assetName);
    }

    public function getPage(): Page
    {
        return $this->page;
    }

    protected function collectContentTypeAssets(Page $page): void
    {
    }
}
