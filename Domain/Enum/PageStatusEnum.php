<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum;

enum PageStatusEnum: string
{
    case DRAFT = 'draft';
    case HIDDEN = 'hidden';
    case PUBLISHED = 'published';
}
