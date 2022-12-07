<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Presentation\Controller\Backoffice\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\DomainInteractionInterface;

class ContentTemplateController extends AbstractController
{
    public function getContentTemplateFields(
        string $templateName,
        int $pageId,
        DomainInteractionInterface $domainInteraction
    ): Response {
        $templateName .= '.html.twig';

        $page = $domainInteraction->getPageService()->findOrThrowPageById($pageId);
        $fields = $domainInteraction->getTwigLayoutService()->getContentTemplateFields($page, $templateName);

        return $this->json([]);
    }
}
