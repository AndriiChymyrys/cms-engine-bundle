<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Layout;

use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;

interface TwigLayoutServiceInterface
{
    /**
     * @param Page $page
     *
     * @return array
     */
    public function getContentBlocks(Page $page): array;

    /**
     * @param Page $page
     *
     * @return array
     */
    public function getContentTemplates(Page $page): array;

    /**
     * @param Page $page
     * @param string $contentTemplateName
     *
     * @return array
     */
    public function getContentTemplateFields(Page $page, string $contentTemplateName): array;
}
