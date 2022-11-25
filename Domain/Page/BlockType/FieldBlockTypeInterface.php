<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\BlockType;

use App\Entity\Cms\Page;
use App\Entity\Cms\Field;
use App\Entity\Cms\Content;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Dto\ContentTypeDto;

/**
 * Class FieldBlockTypeInterface
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\BlockType
 */
interface FieldBlockTypeInterface
{
    /**
     * @param Content $content
     * @param Page $page
     * @param ContentTypeDto $contentData
     *
     * @return Field
     */
    public function getField(Content $content, Page $page, ContentTypeDto $contentData): Field;

    /**
     * @param Field $field
     * @param ContentTypeDto $contentData
     *
     * @return void
     */
    public function saveField(Field $field, ContentTypeDto $contentData): void;

    /**
     * @param Field $field
     *
     * @return mixed
     */
    public function getFieldContent(Field $field): mixed;
}
