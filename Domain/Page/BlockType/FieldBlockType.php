<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\BlockType;

use App\Entity\Cms\Page;
use App\Entity\Cms\Field;
use App\Entity\Cms\Content;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Dto\ContentTypeDto;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\ContentTypeEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Event\BeforeContentTypeSaveEvent;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\ContentViewFactoryInterface;

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
     * @param EventDispatcherInterface $eventDispatcher
     * @param ContentViewFactoryInterface $contentViewFactory
     */
    public function __construct(
        protected ThemeManagerServiceInterface $themeManagerService,
        protected EntityManagerInterface $entityManager,
        protected EventDispatcherInterface $eventDispatcher,
        protected ContentViewFactoryInterface $contentViewFactory,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getField(Content $content, Page $page, ContentTypeDto $contentData): Field
    {
        if ($contentData->saved) {
            return $this->entityManager->getRepository(Field::class)->find($contentData->id);
        }

        $entityField = new Field();
        $fieldDbType = $this
            ->themeManagerService
            ->getThemeFieldProvider(
                $contentData->typeTheme,
                $contentData->contentKey
            )
            ->getDatabaseType()->value;

        $entityField
            ->setType($contentData->contentKey)
            ->setLayout($page->getLayout())
            ->setProvideTheme($contentData->typeTheme)
            ->setContent($content)
            ->setConfig($contentData->configs)
            ->setOrder($contentData->order)
            ->setDbType($fieldDbType);

        $content->addField($entityField);

        $this->entityManager->persist($entityField);

        return $entityField;
    }

    /**
     * {@inheritDoc}
     */
    public function saveField(Field $field, ContentTypeDto $contentData): void
    {
        $event = $this->fireBeforeSaveEvent($field, $contentData->value, $contentData->configs);

        $this
            ->entityManager
            ->getRepository(Field::class)
            ->updateFieldContent($field, $event->getValue(), $event->getConfigs(), $contentData);
    }

    /**
     * {@inheritDoc}
     */
    public function getPageContentFields(Content $content, Page $page, &$contentTypes): void
    {
        foreach ($content->getFields() as $field) {
            $fieldContent = $this
                ->entityManager
                ->getRepository(Field::class)
                ->getFieldContent($field);

            $editView = $this
                ->contentViewFactory
                ->getContentView(ContentTypeEnum::FIELD)
                ->getEditView($field->getProvideTheme(), $field->getType(), true);

            $contentTypes[] = [
                'id' => $field->getId(),
                'contentType' => ContentTypeEnum::FIELD->value,
                'contentKey' => $field->getType(),
                'editView' => $editView->getEditView(
                    $fieldContent ? $fieldContent->getValue() : null,
                    $field->getConfig() ?? []
                ),
                'configs' => $field->getConfig(),
                'order' => $field->getOrder(),
                'typeTheme' => $field->getProvideTheme(),
            ];
        }
    }

    /**
     * @param Field $field
     * @param mixed $value
     * @param array $configs
     *
     * @return BeforeContentTypeSaveEvent
     */
    protected function fireBeforeSaveEvent(Field $field, mixed $value, array $configs): BeforeContentTypeSaveEvent
    {
        $eventName = sprintf(
            '%s.%s.%s.%s',
            BeforeContentTypeSaveEvent::NAME,
            ContentTypeEnum::FIELD->value,
            $field->getProvideTheme(),
            $field->getType()
        );

        $event = new BeforeContentTypeSaveEvent($value, $configs);

        $this->eventDispatcher->dispatch($event, $eventName);

        return $event;
    }
}
