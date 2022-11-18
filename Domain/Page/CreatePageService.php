<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page;

use Doctrine\ORM\EntityManagerInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeManagerServiceInterface;
use WideMorph\Morph\Bundle\MorphCoreBundle\Domain\Services\Input\InputDataCollectionInterface;

/**
 * Class CreatePageService
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page
 */
class CreatePageService implements CreatePageServiceInterface
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param ThemeManagerServiceInterface $themeManagerService
     */
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ThemeManagerServiceInterface $themeManagerService
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function create(InputDataCollectionInterface $inputDataCollection): mixed
    {
        if ($inputDataCollection->hasForm()) {
            /** @var Page $page */
            $page = $inputDataCollection->getForm()->getData();
            $themeProvider = $this->themeManagerService->getThemeProviderByLayout($page->getLayout());
            $page->setTheme($themeProvider->getName());

            $this->entityManager->persist($page);
            $this->entityManager->flush();

            return $page;
        }

        return null;
    }
}
