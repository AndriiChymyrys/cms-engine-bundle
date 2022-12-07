<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\Publish;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\TemplatePathResolverInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\ThemeProviderInterface;

class PublishService implements PublishServiceInterface
{
    /**
     * @param ThemeManagerServiceInterface $themeManagerService
     * @param TemplatePathResolverInterface $templatePathResolver
     * @param PublishFileManagerInterface $fileManager
     */
    public function __construct(
        protected ThemeManagerServiceInterface $themeManagerService,
        protected TemplatePathResolverInterface $templatePathResolver,
        protected PublishFileManagerInterface $fileManager,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function publish(?string $themeName = null): void
    {
        $themes = [];

        if ($themeName) {
            $themes[$themeName] = $this->themeManagerService->getThemeProviderByName($themeName);
        } else {
            $themes = $this->themeManagerService->getAllThemeProviders();
        }

        /**
         * @var ThemeProviderInterface $provider
         */
        foreach ($themes as $provider) {
            $this->copyLayout($provider);
            $this->copyContentTemplate($provider);
        }
    }

    /**
     * @param ThemeProviderInterface $provider
     *
     * @return void
     */
    protected function copyLayout(ThemeProviderInterface $provider): void
    {
        foreach ($provider->getLayouts() as $layout) {
            $bundleRootDir = $this->templatePathResolver->getBundleDir($layout->getTemplatePath());
            if ($bundleRootDir) {
                $publicDir = $this->templatePathResolver->getPublicDir(
                    $provider->getName(),
                    TemplatePathResolverInterface::THEME_LAYOUT_TYPE
                );

                $this->fileManager->copyTemplate($bundleRootDir, $publicDir);
            }
        }
    }

    /**
     * @param ThemeProviderInterface $provider
     *
     * @return void
     */
    protected function copyContentTemplate(ThemeProviderInterface $provider): void
    {
        $templatePath = $provider->getContentTemplatesPath();

        if ($templatePath) {
            $bundleRootDir = $this->templatePathResolver->getBundleDir($templatePath);
            if ($bundleRootDir) {
                $publicDir = $this->templatePathResolver->getPublicDir(
                    $provider->getName(),
                    TemplatePathResolverInterface::THEME_CONTENT_TEMPLATE_TYPE
                );

                $this->fileManager->copyRecursive($bundleRootDir, $publicDir);
            }
        }
    }
}
