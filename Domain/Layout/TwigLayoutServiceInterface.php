<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Layout;

use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;

interface TwigLayoutServiceInterface
{
    public function getContentBlocks(Page $page): array;
}
