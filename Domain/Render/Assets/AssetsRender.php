<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\Assets;

use Generator;

class AssetsRender implements AssetsRenderInterface
{
    /**
     * @var array
     */
    protected array $assets;

    /**
     * {@inheritDoc}
     */
    public function setAssets(array $assets): self
    {
        $this->assets = $assets;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAssets(string $place): Generator
    {
        $assetPlace = $this->assets[$place] ?? [];

        foreach ($assetPlace as $assetsType => $paths) {
            $this->sortByPriority($paths);

            foreach ($paths as $config) {
                yield $assetsType => $config;
            }
        }
    }

    /**
     * @param $paths
     *
     * @return void
     */
    protected function sortByPriority(&$paths): void
    {
        uasort($paths, static function ($a, $b) {
            if (isset($a['priority']) || isset($b['priority'])) {
                return 0;
            }

            if ($a['priority'] === $b['priority']) {
                return 0;
            }

            return ($a['priority'] > $b['priority']) ? -1 : 1;
        });
    }
}
