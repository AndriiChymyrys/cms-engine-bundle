<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page;

use App\Entity\Cms\Page;

interface PageServiceInterface
{
    public function findOrThrowPageById(int $pageId): Page;

    public function saveContentBlocks(Page $page, array $blocks): void;

    public function fetchPageBlocks(Page $page, array $blocks): array;
}
