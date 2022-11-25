<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\BlockType;

use App\Entity\Cms\Page;
use App\Entity\Cms\Field;
use App\Entity\Cms\Content;
use Doctrine\ORM\EntityManagerInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Dto\ContentTypeDto;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;

/**
 * Class FieldBlockType
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\BlockType
 */
class FieldBlockType implements FieldBlockTypeInterface
{
    /**
     * @param ThemeManagerServiceInterface $themeManagerService
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        protected ThemeManagerServiceInterface $themeManagerService,
        protected EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getField(Content $content, Page $page, ContentTypeDto $contentData): Field
    {
        $entityField = null;

        if ($contentData->saved) {
            $entityField = $this->entityManager->getRepository(Field::class)->find($contentData->id);
        }

        if (!$entityField) {
            $entityField = new Field();
            $fieldDbType = $this
                ->themeManagerService
                ->getThemeFieldProvider(
                    $page->getTheme(),
                    $contentData->contentKey
                )
                ->getDatabaseType()->value;

            $entityField
                ->setType($contentData->contentKey)
                ->setLayout($page->getLayout())
                ->setTheme($page->getTheme())
                ->setContent($content)
                ->setDbType($fieldDbType);

            $content->addField($entityField);

            $this->entityManager->persist($entityField);
        }

        return $entityField;
    }

    /**
     * {@inheritDoc}
     */
    public function saveField(Field $field, ContentTypeDto $contentData): void
    {
        $this
            ->entityManager
            ->getRepository(Field::class)
            ->updateFieldContent($field, $contentData->value);
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldContent(Field $field): mixed
    {
        return $this
            ->entityManager
            ->getRepository(Field::class)
            ->getFieldContent($field);
    }
}
