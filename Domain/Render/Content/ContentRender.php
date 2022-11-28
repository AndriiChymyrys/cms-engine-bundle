<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\Content;

use Generator;
use App\Entity\Cms\Field;
use App\Entity\Cms\Widget;
use App\Entity\Cms\Content;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\ContentTypeEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\PageRenderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Event\ContentRenderEvent;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\ContentViewFactoryInterface;

/**
 * Class ContentRender
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\Content
 */
class ContentRender implements ContentRenderInterface
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param ContentViewFactoryInterface $contentViewFactory
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ContentViewFactoryInterface $contentViewFactory,
        protected EventDispatcherInterface $eventDispatcher,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getContent(string $blockName, string $contentName, PageRenderInterface $pageRender): ?Content
    {
        $page = $pageRender->getPage();

        return $this->entityManager->getRepository(Content::class)->getContentBy(
            $page->getId(),
            $blockName,
            $contentName
        );
    }

    /**
     * {@inheritDoc}
     */
    public function renderTypes(Content $content, PageRenderInterface $pageRender): Generator
    {
        $page = $pageRender->getPage();
        $fieldRepository = $this->entityManager->getRepository(Field::class);
        $types = [...$content->getFields(), ...$content->getWidgets()];

        foreach ($types as $type) {
            $fieldValue = null;
            $contentType = ContentTypeEnum::WIDGET;

            if ($type instanceof Field) {
                $fieldValue = $fieldRepository->getFieldContent($type);
                $contentType = ContentTypeEnum::FIELD;
            }

            $event = $this->fireBeforeRenderEvent(
                $type,
                $fieldValue ? $fieldValue->getValue() : null,
                $contentType
            );

            yield $this->contentViewFactory
                ->getContentView($page, $contentType)
                ->getPageView($page, $type->getType(), true)
                ->getPageView($event->getValue(), $event->getConfigs());
        }
    }

    /**
     * @param Field|Widget $contentType
     * @param mixed $value
     * @param ContentTypeEnum $contentTypeEnum
     *
     * @return ContentRenderEvent
     */
    protected function fireBeforeRenderEvent(
        Field|Widget $contentType,
        mixed $value,
        ContentTypeEnum $contentTypeEnum
    ): ContentRenderEvent {
        $eventName = sprintf(
            '%s.%s.%s.%s',
            ContentRenderEvent::NAME,
            $contentTypeEnum->value,
            $contentType->getTheme(),
            $contentType->getType()
        );

        $event = new ContentRenderEvent($value, $contentType->getConfig());

        $this->eventDispatcher->dispatch($event, $eventName);

        return $event;
    }
}
