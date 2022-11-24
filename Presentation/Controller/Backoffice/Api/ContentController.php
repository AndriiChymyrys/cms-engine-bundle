<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Presentation\Controller\Backoffice\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\ContentTypeEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\DomainInteractionInterface;

class ContentController extends AbstractController
{
    public function getAvailableByType(string $type, DomainInteractionInterface $domainInteraction): Response
    {
        $availableTypes = $domainInteraction->getAvailableContentTypesFactory()->getTypes(ContentTypeEnum::from($type));

        return $this->json([
            'available' => $availableTypes,
        ]);
    }

    public function getEditView(
        int $pageId,
        string $contentBlock,
        string $content,
        string $contentType,
        string $contentKey,
        DomainInteractionInterface $domainInteraction
    ): Response {
        $page = $domainInteraction->getPageService()->findOrThrowPageById($pageId);
        $view = $domainInteraction->getContentViewFactory()->getContentView(
            $page,
            ContentTypeEnum::tryFrom($contentType)
        );

        return $this->json([
            'view' => $view->getEditView($page, $contentKey),
        ]);
    }

    public function saveContent(int $pageId, DomainInteractionInterface $domainInteraction, Request $request)
    {
        $page = $domainInteraction->getPageService()->findOrThrowPageById($pageId);
        $requestData = json_decode(json: $request->getContent(), associative: true, flags: JSON_THROW_ON_ERROR);

        $domainInteraction->getPageService()->saveContentBlocks($page, $requestData['blocks']);

        return $this->json([]);
    }

    public function deleteFieldContent(int $page, int $field, DomainInteractionInterface $domainInteraction)
    {
        return $this->json([]);
    }
}
