<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page;

use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;

interface PageServiceInterface
{
    public function findOrThrowPageById(int $pageId): Page;
}
