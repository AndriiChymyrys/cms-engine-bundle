<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme;

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
     */
    public function getBundleDir(string $templatePath): ?string
    {
        $bundleName = $this->extractBundleNameFromPath($templatePath);

        if (!isset($this->bundlesMetadata[$bundleName])) {
            // In case if we have Template from App namespace
            return null;
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

        return sprintf(
            '%s/%s/%s/%s',
            $this->templatePath,
            $themeName,
            $templateType,
            $this->clearBundleNameFromPath($filePath)
        );
    }

    /**
     * @param string $template
     *
     * @return string
     */
    protected function extractBundleNameFromPath(string $template): ?string
    {
        $position = strpos($template, DIRECTORY_SEPARATOR);

        if (!$position) {
            // We can't have "/" in path in case if Template from App namespace
            return null;
        }

        $bundleName = substr($template, 0, $position);

        return sprintf('%sBundle', str_replace('@', '', $bundleName));
    }

    /**
     * @param string $template
     *
     * @return string
     */
    protected function clearBundleNameFromPath(string $template): string
    {
        $index = strpos($template, DIRECTORY_SEPARATOR) ?: 0;

        return substr($template, $index, strlen($template));
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
