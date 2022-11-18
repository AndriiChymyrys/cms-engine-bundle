<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page;

use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Exception\PageNotFoundException;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\MorphCoreInteractionInterface;

class PageService implements PageServiceInterface
{
    public function __construct(protected MorphCoreInteractionInterface $morphCoreInteraction)
    {
    }

    public function findOrThrowPageById(int $pageId): Page
    {
        $page = $this->morphCoreInteraction
            ->getEntityResolver()
            ->getEntityRepository('Cms/Page')
            ->find($pageId);

        if (!$page) {
            throw new PageNotFoundException();
        }

        return $page;
    }
}
