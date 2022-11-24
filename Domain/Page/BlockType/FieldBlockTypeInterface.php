<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\BlockType;

use App\Entity\Cms\Page;
use App\Entity\Cms\Field;
use App\Entity\Cms\Content;

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
     * @param string $contentKey
     *
     * @return Field
     */
    public function getField(Content $content, Page $page, string $contentKey): Field;

    /**
     * @param Field $field
     * @param array $contentData
     *
     * @return void
     */
    public function saveField(Field $field, array $contentData): void;

    /**
     * @param Field $field
     *
     * @return mixed
     */
    public function getFieldContent(Field $field): mixed;
}
