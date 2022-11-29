<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\Assets;

use App\Entity\Cms\Page;

interface AssetsRenderFactoryInterface
{
    /**
     * @param Page $page
     *
     * @return AssetsRenderInterface
     */
    public function getAssetRender(Page $page): AssetsRenderInterface;
}
