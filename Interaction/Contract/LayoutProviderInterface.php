<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract;

interface LayoutProviderInterface
{
    public function getTemplatePath(): string;

    public function getAssetPath(string $assetPath): string;
}
