<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\View;

use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\FieldProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\WidgetProviderInterface;

interface ContentViewTypeInterface
{
    /**
     * @param string $theme
     * @param string $contentKey
     * @param bool $asProvider
     *
     * @return WidgetProviderInterface|FieldProviderInterface|string
     */
    public function getEditView(
        string $theme,
        string $contentKey,
        bool $asProvider = false
    ): WidgetProviderInterface|FieldProviderInterface|string;

    /**
     * @param string $theme
     * @param string $contentKey
     * @param bool $asProvider
     *
     * @return WidgetProviderInterface|FieldProviderInterface|string
     */
    public function getPageView(
        string $theme,
        string $contentKey,
        bool $asProvider = false
    ): WidgetProviderInterface|FieldProviderInterface|string;
}
