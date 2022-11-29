<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\Assets;

use App\Entity\Cms\Page;
use App\Entity\Cms\Field;
use App\Entity\Cms\Widget;
use App\Entity\Cms\ContentBlock;
use Doctrine\ORM\EntityManagerInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\ContentTypeAssetsProviderInterface;

class AssetsRenderFactory implements AssetsRenderFactoryInterface
{
    /**
     * @param AssetsRenderInterface $assetsRender
     * @param EntityManagerInterface $entityManager
     * @param ThemeManagerServiceInterface $themeManagerService
     */
    public function __construct(
        protected AssetsRenderInterface $assetsRender,
        protected EntityManagerInterface $entityManager,
        protected ThemeManagerServiceInterface $themeManagerService
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getAssetRender(Page $page): AssetsRenderInterface
    {
        $contentTypes = $this->getContentTypes($page);
        $assets = $this->buildAssets($contentTypes);

        $this->assetsRender->setAssets($assets);

        return $this->assetsRender;
    }

    /**
     * @param Page $page
     *
     * @return array<Widget|Field>
     */
    protected function getContentTypes(Page $page): array
    {
        $contentBlocks = $this->entityManager
            ->getRepository(ContentBlock::class)
            ->getPageBlocksByLayoutAndTheme($page->getLayout(), $page->getTheme());

        $contentTypes = [];

        foreach ($contentBlocks as $contentBlock) {
            foreach ($contentBlock->getContents() as $content) {
                $contentTypes[] = [...$content->getWidgets(), ...$content->getFields()];
            }
        }

        return array_merge(...$contentTypes);
    }

    /**
     * @param array $contentTypes
     *
     * @return array
     */
    public function buildAssets(array $contentTypes): array
    {
        $assets = [];
        $added = [];

        foreach ($contentTypes as $contentType) {
            if ($contentType instanceof Widget) {
                $themeProvider = $this->themeManagerService->getThemeWidgetProvider(
                    $contentType->getProvideTheme(),
                    $contentType->getType()
                );
            }

            if ($contentType instanceof Field) {
                $themeProvider = $this->themeManagerService->getThemeFieldProvider(
                    $contentType->getProvideTheme(),
                    $contentType->getType()
                );
            }

            if ($themeProvider instanceof ContentTypeAssetsProviderInterface && !isset($added[$themeProvider::class])) {
                $assets[] = $themeProvider->getPageAssets();

                // If the same contentType added many times on the page, execute getPageAssets only once per contentType
                $added[$themeProvider::class] = true;
            }
        }

        return array_merge_recursive(...$assets);
    }
}
