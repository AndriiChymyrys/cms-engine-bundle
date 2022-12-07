<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Presentation\Controller\Backoffice;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\ContentTypeEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\DataSource\CreatePageDataSource;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\DataSource\SelectPageDataSource;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\DomainInteractionInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\MorphCoreInteractionInterface;

/**
 * Class PageController
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Presentation\Controller\Backoffice
 */
class PageController extends AbstractController
{
    /**
     * @param MorphCoreInteractionInterface $morphCoreInteraction
     *
     * @return Response
     */
    public function index(MorphCoreInteractionInterface $morphCoreInteraction): Response
    {
        $outputData = $morphCoreInteraction->getDomainInteraction()->getSelectDataSourceService()->execute(
            SelectPageDataSource::class
        );

        return $this->render('@CmsEngine/backoffice/page/index.html.twig', ['output' => $outputData]);
    }

    /**
     * @param MorphCoreInteractionInterface $morphCoreInteraction
     *
     * @return Response
     */
    public function create(MorphCoreInteractionInterface $morphCoreInteraction): Response
    {
        $outputData = $morphCoreInteraction->getDomainInteraction()->getCreateDataSourceService()->execute(
            CreatePageDataSource::class
        );

        return $this->render('@CmsEngine/backoffice/page/create.html.twig', ['output' => $outputData]);
    }

    /**
     * @param int $pageId
     * @param DomainInteractionInterface $domainInteraction
     *
     * @return Response
     */
    public function editContentBlocks(int $pageId, DomainInteractionInterface $domainInteraction): Response
    {
        $page = $domainInteraction->getPageService()->findOrThrowPageById($pageId);
        $themeProvider = $domainInteraction->getThemeManagerService()->getThemeProviderByName($page->getTheme());
        $contentBlocks = $domainInteraction->getTwigLayoutService()->getContentBlocks($page);
        $contentBlocks = $domainInteraction->getPageService()->fetchPageBlocks($page, $contentBlocks);
        $contentTypes = [ContentTypeEnum::FIELD, ContentTypeEnum::WIDGET];

        return $this->render(
            '@CmsEngine/backoffice/page/edit_content_block.html.twig',
            [
                'page' => $page,
                'themeProvider' => $themeProvider,
                'contentBlocks' => $contentBlocks,
                'contentTypes' => $contentTypes,
            ]
        );
    }

    /**
     * @param int $pageId
     * @param DomainInteractionInterface $domainInteraction
     *
     * @return Response
     */
    public function editContentTemplates(int $pageId, DomainInteractionInterface $domainInteraction): Response
    {
        $page = $domainInteraction->getPageService()->findOrThrowPageById($pageId);
        $contentTemplates = $domainInteraction->getTwigLayoutService()->getContentTemplates($page);

        return $this->render(
            '@CmsEngine/backoffice/page/edit_content_template.html.twig',
            [
                'page' => $page,
                'contentTemplates' => $contentTemplates,
            ]
        );
    }
}
