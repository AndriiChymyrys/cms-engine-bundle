<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme;

interface TemplatePathResolverInterface
{
    public const THEME_CONTENT_TEMPLATE_TYPE = 'content_template';
    public const THEME_LAYOUT_TYPE = 'layout';

    /**
     * @param string $themeName
     * @param string $templateType
     *
     * @return string
     */
    public function getPublicDir(string $themeName, string $templateType): string;

    /**
     * @param string $templatePath
     *
     * @return string
     */
    public function getBundleDir(string $templatePath): string;

    /**
     * @param string $themeName
     * @param string $templateType
     * @param string $filePath
     *
     * @return string
     */
    public function getFullPublicFileName(string $themeName, string $templateType, string $filePath): string;
}
