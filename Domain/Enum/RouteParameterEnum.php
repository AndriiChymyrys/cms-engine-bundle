<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum;

enum RouteParameterEnum: string
{
    case PAGE = '_page';
    case CONTROLLER = '_controller';
}
