<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\View;

use App\Entity\Cms\Field;
use Doctrine\ORM\EntityManagerInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;

class FieldContentViewPage implements ContentViewTypeInterface
{
    public function __construct(
        protected ThemeManagerServiceInterface $themeManagerService,
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function getEditView(
        Page $page,
        string $contentBlock,
        string $content,
        string $contentKey
    ): string {
        $field = $this->entityManager->getRepository(Field::class)
            ->getFieldContentType($page->getId(), $contentBlock, $content, $page->getTheme(), $contentKey);

        $themeField = $this->themeManagerService->getThemeFieldProvider(
            $page->getTheme(),
            $contentKey
        );

        $fieldContent = null;

        if ($field) {
            $fieldContent = $this->entityManager->getRepository(Field::class)->getFieldContent($field);
        }

        return $themeField->getEditView($fieldContent ? $fieldContent->getValue() : '');
    }

    public function getPageView(): string
    {
        return '';
    }
}
