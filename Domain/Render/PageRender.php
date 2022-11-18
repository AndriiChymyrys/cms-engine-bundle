<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render;

use App\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\RouteParameterEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\DomainInteractionInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\ThemeProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\LayoutProviderInterface;

class PageRender implements PageRenderInterface
{
    protected Page $page;

    protected LayoutProviderInterface $layoutProvider;

    protected ThemeProviderInterface $themeProvider;

    public function __construct(protected array $pageData, protected DomainInteractionInterface $domainInteraction)
    {
        $this->page = $this->pageData[RouteParameterEnum::PAGE->value];
        $this->themeProvider = $this->domainInteraction
            ->getThemeManagerService()
            ->getThemeProviderByName($this->page->getTheme());
        $this->layoutProvider = $this->domainInteraction
            ->getThemeManagerService()
            ->getThemeLayoutProvider($this->themeProvider, $this->page->getLayout());
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
}
