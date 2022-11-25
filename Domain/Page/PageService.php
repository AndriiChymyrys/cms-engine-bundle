<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page;

use App\Entity\{Cms\Page, Cms\Field, Cms\Widget, Cms\Content, Cms\ContentBlock};
use Doctrine\ORM\EntityManagerInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Dto\ContentTypeDto;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\ContentTypeEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Exception\PagePersistException;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Exception\PageNotFoundException;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\BlockType\FieldBlockTypeInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\ContentViewFactoryInterface;

class PageService implements PageServiceInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected FieldBlockTypeInterface $fieldBlockType,
        protected ContentViewFactoryInterface $contentViewFactory,
    ) {
    }

    public function findOrThrowPageById(int $pageId): Page
    {
        $page = $this->entityManager->getRepository(Page::class)->find($pageId);

        if (!$page) {
            throw new PageNotFoundException();
        }

        return $page;
    }

    public function saveContentBlocks(Page $page, array $blocks): void
    {
        foreach ($blocks as $blockName => $blockContent) {
            $entityContentBlock = $this->getContentBlock($page, $blockName);
            foreach ($blockContent as $contentName => $contentData) {
                foreach ($contentData as $content) {
                    $contentDto = new ContentTypeDto($content);
                    $type = ContentTypeEnum::from($contentDto->contentType);
                    $entityContent = $this->getContent($entityContentBlock, $type, $contentName);
                    $entityContentValue = $this->getContentValue(
                        $entityContent,
                        $type,
                        $page,
                        $contentDto
                    );
                    $this->updateContentValue($entityContentValue, $contentDto);
                }
            }

            $this->entityManager->flush();
        }
    }

    public function fetchPageBlocks(Page $page, array $blocks): array
    {
        foreach ($blocks as $blockName => &$blockContent) {
            $contentBlock = $this
                ->entityManager
                ->getRepository(ContentBlock::class)
                ->getPageBlockByName($page, $blockName);

            foreach ($blockContent['contents'] as $contentName => &$value) {
                /** @var Content $content */
                foreach ($contentBlock->getContents() as $content) {
                    if ($content->getName() === $contentName) {
                        foreach ($content->getFields() as $field) {
                            $fieldContent = $this->fieldBlockType->getFieldContent($field);
                            $editView = $this
                                ->contentViewFactory
                                ->getContentView($page, ContentTypeEnum::FIELD)
                                ->getEditView($page, $field->getType(), true);

                            $value[] = [
                                'id' => $field->getId(),
                                'contentType' => ContentTypeEnum::FIELD->value,
                                'contentKey' => $field->getType(),
                                'editView' => $editView->getEditView($fieldContent ? $fieldContent->getValue() : null),
                            ];
                        }

//                        foreach ($content->getWidgets() as $widget) {
//
//                        }
                    }
                }
            }
        }

        return $blocks;
    }

    protected function getContentBlock(Page $page, string $blockName): ContentBlock
    {
        $contentBlock = $this
            ->entityManager
            ->getRepository(ContentBlock::class)
            ->getPageBlockByName($page, $blockName);

        if (!$contentBlock) {
            $contentBlock = new ContentBlock();
            $contentBlock
                ->setName($blockName)
                ->setTheme($page->getTheme())
                ->setLayout($page->getLayout());

            $page->addContentBlock($contentBlock);

            $this->entityManager->persist($contentBlock);
        }

        return $contentBlock;
    }

    protected function getContent(
        ContentBlock $contentBlock,
        ContentTypeEnum $contentTypeEnum,
        string $contentName
    ): Content {
        $entityContent = null;

        foreach ($contentBlock->getContents() as $content) {
            if ($content->getName() === $contentName && $content->getType() === $contentTypeEnum->value) {
                $entityContent = $content;
            }
        }

        if (!$entityContent) {
            $entityContent = new Content();
            $entityContent->setName($contentName)
                ->setContentBlock($contentBlock)
                ->setType($contentTypeEnum->value)
                ->setOrder(1);

            $contentBlock->addContent($entityContent);

            $this->entityManager->persist($entityContent);
        }

        return $entityContent;
    }

    protected function getContentValue(
        Content $content,
        ContentTypeEnum $contentTypeEnum,
        Page $page,
        ContentTypeDto $contentData
    ): Field|Widget {
        if ($contentTypeEnum->name === ContentTypeEnum::FIELD->name) {
            return $this->fieldBlockType->getField($content, $page, $contentData);
        } elseif ($contentTypeEnum->name === ContentTypeEnum::WIDGET->name) {
        }

        throw new PagePersistException(sprintf('Can not find content for type "%s"', $contentTypeEnum->name));
    }

    protected function updateContentValue(Field|Widget $value, ContentTypeDto $contentData): void
    {
        if ($value instanceof Field) {
            $this->fieldBlockType->saveField($value, $contentData);
        } elseif ($value instanceof Widget) {
        } else {
            throw new PagePersistException(
                sprintf(
                    'Can not save content for content value type "%s"',
                    get_class($value)
                )
            );
        }
    }
}
