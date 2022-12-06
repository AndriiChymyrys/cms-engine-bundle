<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum;

enum ContentTypeEnum: string
{
    case FIELD = 'field';
    case CONTENT_TEMPLATE = 'contentTemplate';
    case WIDGET = 'widget';
}
