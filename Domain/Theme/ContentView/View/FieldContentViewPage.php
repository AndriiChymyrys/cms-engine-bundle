<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\View;

use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\DomainInteraction;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\MorphCoreInteractionInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;

class FieldContentViewPage implements ContentViewTypeInterface
{
    public function __construct(
        protected MorphCoreInteractionInterface $morphCoreInteraction,
        protected ThemeManagerServiceInterface $themeManagerService,
    ) {
    }

    public function getEditView(
        Page $page,
        string $contentBlock,
        string $content,
        string $contentKey
    ): string {
        $fieldRepository = $this->morphCoreInteraction
            ->getEntityResolver()
            ->getEntityRepository('Cms/Field');

        $field = $fieldRepository
            ->getFieldContentType($page->getId(), $contentBlock, $content, $page->getTheme(), $contentKey);

        $themeField = $this->themeManagerService->getThemeFieldProvider(
            $page->getTheme(),
            $contentKey
        );

        $fieldContent = null;

        if ($field) {
            $fieldContent = $fieldRepository->getFieldContent($field);
        }

        return $themeField->getEditView($fieldContent ? $fieldContent->getValue() : '');
    }

    public function getPageView(): string
    {
        return '';
    }
}
