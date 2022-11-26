<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\Content;

use Generator;
use App\Entity\Cms\Field;
use App\Entity\Cms\Content;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\ContentTypeEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\PageRenderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Event\BeforeContentRenderEvent;
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

        foreach ($content->getFields() as $field) {
            $fieldValue = $fieldRepository->getFieldContent($field);
            $event = $this->fireBeforeRenderEvent(
                $field,
                $fieldValue->getValue(),
                ContentTypeEnum::FIELD
            );

            yield $this->contentViewFactory
                ->getContentView($page, ContentTypeEnum::FIELD)
                ->getPageView($page, $field->getType(), true)
                ->getPageView($event->getValue());
        }

//        foreach ($content->getWidgets() as $widget) {
//
//        }

        return '';
    }

    /**
     * @param Field $field
     * @param mixed $value
     * @param ContentTypeEnum $contentTypeEnum
     *
     * @return BeforeContentRenderEvent
     */
    protected function fireBeforeRenderEvent(
        Field $field,
        mixed $value,
        ContentTypeEnum $contentTypeEnum
    ): BeforeContentRenderEvent {
        $eventName = sprintf(
            '%s.%s.%s.%s',
            BeforeContentRenderEvent::NAME,
            $contentTypeEnum->value,
            $field->getTheme(),
            $field->getType()
        );

        $event = new BeforeContentRenderEvent($value);

        $this->eventDispatcher->dispatch($event, $eventName);

        return $event;
    }
}
