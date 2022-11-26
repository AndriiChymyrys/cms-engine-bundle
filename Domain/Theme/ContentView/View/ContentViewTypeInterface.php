<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\View;

use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\FieldProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\WidgetProviderInterface;

interface ContentViewTypeInterface
{
    /**
     * @param Page $page
     * @param string $contentKey
     * @param bool $asProvider
     *
     * @return WidgetProviderInterface|FieldProviderInterface|string
     */
    public function getEditView(
        Page $page,
        string $contentKey,
        bool $asProvider = false
    ): WidgetProviderInterface|FieldProviderInterface|string;

    /**
     * @param Page $page
     * @param string $contentKey
     * @param bool $asProvider
     *
     * @return WidgetProviderInterface|FieldProviderInterface|string
     */
    public function getPageView(
        Page $page,
        string $contentKey,
        bool $asProvider = false
    ): WidgetProviderInterface|FieldProviderInterface|string;
}
