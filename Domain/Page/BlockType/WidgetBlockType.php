<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\BlockType;

use App\Entity\Cms\Page;
use App\Entity\Cms\Widget;
use App\Entity\Cms\Content;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Dto\ContentTypeDto;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\ContentTypeEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Event\BeforeContentTypeSaveEvent;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\ContentViewFactoryInterface;

class WidgetBlockType implements WidgetBlockTypeInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected EventDispatcherInterface $eventDispatcher,
        protected ContentViewFactoryInterface $contentViewFactory,
    ) {
    }

    public function getWidget(Content $content, Page $page, ContentTypeDto $contentData): Widget
    {
        if ($contentData->saved) {
            return $this->entityManager->getRepository(Widget::class)->find($contentData->id);
        }

        $widget = new Widget();
        $widget
            ->setProvideTheme($contentData->typeTheme)
            ->setTheme($page->getTheme())
            ->setLayout($page->getLayout())
            ->setConfig($contentData->configs)
            ->setType($contentData->contentKey)
            ->setOrder($contentData->order)
            ->setContent($content);

        $content->addWidget($widget);

        $this->entityManager->persist($widget);

        return $widget;
    }

    public function updateWidget(Widget $widget, ContentTypeDto $contentData): void
    {
        $event = $this->fireBeforeSaveEvent($widget, $contentData->configs);

        $widget->setConfig($event->getConfigs())->setOrder($contentData->order);
    }

    public function getPageContentFields(Content $content, Page $page, &$contentTypes): void
    {
        foreach ($content->getWidgets() as $widget) {
            $editView = $this
                ->contentViewFactory
                ->getContentView(ContentTypeEnum::WIDGET)
                ->getEditView($widget->getProvideTheme(), $widget->getType(), true);

            $contentTypes[] = [
                'id' => $widget->getId(),
                'contentType' => ContentTypeEnum::WIDGET->value,
                'contentKey' => $widget->getType(),
                'typeTheme' => $widget->getProvideTheme(),
                'editView' => $editView->getEditView(configs: $widget->getConfig()),
                'configs' => $widget->getConfig(),
                'order' => $widget->getOrder(),
            ];
        }
    }

    protected function fireBeforeSaveEvent(Widget $widget, array $configs): BeforeContentTypeSaveEvent
    {
        $eventName = sprintf(
            '%s.%s.%s.%s',
            BeforeContentTypeSaveEvent::NAME,
            ContentTypeEnum::FIELD->value,
            $widget->getProvideTheme(),
            $widget->getType()
        );
        $event = new BeforeContentTypeSaveEvent(null, $configs);

        $this->eventDispatcher->dispatch($event, $eventName);

        return $event;
    }
}
