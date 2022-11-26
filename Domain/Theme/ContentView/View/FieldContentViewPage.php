<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\View;

use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\FieldProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\WidgetProviderInterface;

class FieldContentViewPage implements ContentViewTypeInterface
{
    /**
     * @param ThemeManagerServiceInterface $themeManagerService
     */
    public function __construct(protected ThemeManagerServiceInterface $themeManagerService)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getEditView(
        Page $page,
        string $contentKey,
        bool $asProvider = false
    ): WidgetProviderInterface|FieldProviderInterface|string {
        $themeField = $this->themeManagerService->getThemeFieldProvider(
            $page->getTheme(),
            $contentKey
        );

        return $asProvider === false ? $themeField->getEditView() : $themeField;
    }

    /**
     * {@inheritDoc}
     */
    public function getPageView(
        Page $page,
        string $contentKey,
        bool $asProvider = false
    ): WidgetProviderInterface|FieldProviderInterface|string {
        $themeField = $this->themeManagerService->getThemeFieldProvider(
            $page->getTheme(),
            $contentKey
        );

        return $asProvider === false ? $themeField->getPageView() : $themeField;
    }
}
