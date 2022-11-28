<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render;

use App\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\ThemeProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\LayoutProviderInterface;

interface PageRenderInterface
{
    public function getLayoutName(): string;

    public function getThemeProvider(): ThemeProviderInterface;

    public function getLayoutProvider(): LayoutProviderInterface;

    public function getAsset(string $assetName): string;

    public function getPage(): Page;

    public function init(array $attributes): self;
}
