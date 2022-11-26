<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\BlockType;

use App\Entity\Cms\Page;
use App\Entity\Cms\Widget;
use App\Entity\Cms\Content;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Dto\ContentTypeDto;

interface WidgetBlockTypeInterface
{
    /**
     * @param Content $content
     * @param Page $page
     * @param ContentTypeDto $contentData
     *
     * @return Widget
     */
    public function getWidget(Content $content, Page $page, ContentTypeDto $contentData): Widget;

    /**
     * @param Widget $widget
     * @param ContentTypeDto $contentData
     *
     * @return void
     */
    public function updateWidget(Widget $widget, ContentTypeDto $contentData): void;

    /**
     * @param Content $content
     * @param Page $page
     * @param $contentTypes
     *
     * @return void
     */
    public function getPageContentFields(Content $content, Page $page, &$contentTypes): void;
}
