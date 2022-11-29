<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\PageRenderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\ContentTypeAssetsProviderInterface;

class PageAssetsExtension extends AbstractExtension
{
    /**
     * {@inheritDoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('content_type_assets', [$this, 'getContentTypeAssets'], ['is_safe' => ['all']])
        ];
    }

    /**
     * @param PageRenderInterface $pageRender
     * @param string $place
     *
     * @return string
     */
    public function getContentTypeAssets(PageRenderInterface $pageRender, string $place): string
    {
        $assetsRender = $pageRender->getContentTypeAssets();

        foreach ($assetsRender->getAssets($place) as $assetType => $config) {
            if ($assetType === ContentTypeAssetsProviderInterface::CONTENT_TYPE_JS) {
                return $this->renderContentTypeJs($config);
            }

            if ($assetType === ContentTypeAssetsProviderInterface::CONTENT_TYPE_CSS) {
                return $this->renderContentTypeCss($config);
            }
        }

        return '';
    }

    /**
     * @param array $config
     *
     * @return string
     */
    protected function renderContentTypeJs(array $config): string
    {
        return sprintf(
            '<script src="%s" %s %s></script>',
            $config['path'],
            isset($config['defer']) && $config['defer'] ? 'defer' : '',
            isset($config['async']) && $config['async'] ? 'async' : ''
        );
    }

    /**
     * @param array $config
     *
     * @return string
     */
    protected function renderContentTypeCss(array $config): string
    {
        return sprintf(
            '<link rel="stylesheet" href="%s">',
            $config['path'],
        );
    }
}
