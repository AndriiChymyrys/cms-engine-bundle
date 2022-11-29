<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\Assets;

use Generator;

interface AssetsRenderInterface
{
    /**
     * @param array $assets
     *
     * @return $this
     */
    public function setAssets(array $assets): self;

    /**
     * @param string $place
     *
     * @return Generator
     */
    public function getAssets(string $place): Generator;
}
