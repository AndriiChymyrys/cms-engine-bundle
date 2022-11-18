<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Presentation\Controller\Backoffice\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\ContentTypeEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\DomainInteractionInterface;

class ContentController extends AbstractController
{
    public function getAvailableByType(string $type, DomainInteractionInterface $domainInteraction): Response
    {
        $availableTypes = $domainInteraction->getAvailableContentFactory()->getContents(ContentTypeEnum::from($type));

        return $this->json([
            'available' => $availableTypes,
        ]);
    }
}
