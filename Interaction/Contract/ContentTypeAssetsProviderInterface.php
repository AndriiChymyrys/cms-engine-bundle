<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract;

interface ContentTypeAssetsProviderInterface
{
    public const CONTENT_TYPE_ASSET_PLACE_HEAD = 'head';
    public const CONTENT_TYPE_ASSET_PLACE_BOTTOM = 'bottom';

    public const CONTENT_TYPE_JS = 'js';
    public const CONTENT_TYPE_CSS = 'css';

    public function getPageAssets(): array;
}
