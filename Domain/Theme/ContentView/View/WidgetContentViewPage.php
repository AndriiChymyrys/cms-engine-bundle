<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\View;

use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\FieldProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\WidgetProviderInterface;

class WidgetContentViewPage implements ContentViewTypeInterface
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
    public function getEditView(string $theme, string $contentKey, bool $asProvider = false): WidgetProviderInterface|FieldProviderInterface|string
    {
        $widget = $this->themeManagerService->getThemeWidgetProvider($theme, $contentKey);

        return $asProvider === false ? $widget->getEditView() : $widget;
    }

    /**
     * {@inheritDoc}
     */
    public function getPageView(Page $page, string $contentKey, bool $asProvider = false): WidgetProviderInterface|FieldProviderInterface|string
    {
        $widget = $this->themeManagerService->getThemeWidgetProvider($page->getTheme(), $contentKey);

        return $asProvider === false ? $widget->getPageView() : $widget;
    }
}
