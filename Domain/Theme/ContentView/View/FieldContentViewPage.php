<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\View;

use Doctrine\ORM\EntityManagerInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\FieldProviderInterface;

class FieldContentViewPage implements ContentViewTypeInterface
{
    public function __construct(
        protected ThemeManagerServiceInterface $themeManagerService,
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function getEditView(Page $page, string $contentKey, bool $asProvider = false): FieldProviderInterface|string
    {
        $themeField = $this->themeManagerService->getThemeFieldProvider(
            $page->getTheme(),
            $contentKey
        );

        return $asProvider === false ? $themeField->getEditView(null) : $themeField;
    }

    public function getPageView(Page $page, string $contentKey, bool $asProvider = false): FieldProviderInterface|string
    {
        $themeField = $this->themeManagerService->getThemeFieldProvider(
            $page->getTheme(),
            $contentKey
        );

        return $asProvider === false ? $themeField->getPageView(null) : $themeField;
    }
}
