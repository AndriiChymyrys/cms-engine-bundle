<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Exception\ThemeProviderException;

class TemplatePathResolver implements TemplatePathResolverInterface
{
    /**
     * @param array $bundlesMetadata
     * @param string $projectDir
     * @param string $templatePath
     * @param string $contentTemplatesPath
     * @param string $layoutsPath
     */
    public function __construct(
        protected array $bundlesMetadata,
        protected string $projectDir,
        protected string $templatePath,
        protected string $contentTemplatesPath,
        protected string $layoutsPath
    ) {
    }

    /**
     * {@inheritDoc}
     *
     * @throws ThemeProviderException
     */
    public function getBundleDir(string $templatePath): string
    {
        $bundleName = $this->extractBundleNameFromPath($templatePath);

        if (!isset($this->bundlesMetadata[$bundleName])) {
            throw new ThemeProviderException(sprintf('Can not find metadata for bundle "%s"', $bundleName));
        }

        $bundleRootPath = $this->bundlesMetadata[$bundleName]['path'];

        return sprintf('%s/Resources/views%s', $bundleRootPath, $this->clearBundleNameFromPath($templatePath));
    }

    /**
     * {@inheritDoc}
     */
    public function getPublicDir(string $themeName, string $templateType): string
    {
        $type = $this->getThemeContentTypePath($templateType);

        return sprintf(
            '%s/templates/%s/%s/%s',
            $this->projectDir,
            $this->templatePath,
            $themeName,
            $type
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getFullPublicFileName(string $themeName, string $templateType, string $filePath): string
    {
        $templateType = $this->getThemeContentTypePath($templateType);

        return sprintf('%s/%s/%s/%s', $this->templatePath, $themeName, $templateType, basename($filePath));
    }

    /**
     * @param string $template
     *
     * @return string
     */
    protected function extractBundleNameFromPath(string $template): string
    {
        $bundleName = substr($template, 0, strpos($template, DIRECTORY_SEPARATOR));

        return sprintf('%sBundle', str_replace('@', '', $bundleName));
    }

    /**
     * @param string $template
     *
     * @return string
     */
    protected function clearBundleNameFromPath(string $template): string
    {
        return substr($template, strpos($template, DIRECTORY_SEPARATOR), strlen($template));
    }

    /**
     * @param string $templateType
     *
     * @return string
     */
    protected function getThemeContentTypePath(string $templateType): string
    {
        return match (true) {
            $templateType === TemplatePathResolverInterface::THEME_CONTENT_TEMPLATE_TYPE => $this->contentTemplatesPath,
            $templateType === TemplatePathResolverInterface::THEME_LAYOUT_TYPE => $this->layoutsPath,
            default => ''
        };
    }
}
