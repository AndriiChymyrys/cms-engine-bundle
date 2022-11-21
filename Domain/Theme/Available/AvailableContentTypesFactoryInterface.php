<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\Available;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\ContentTypeEnum;

interface AvailableContentTypesFactoryInterface
{
    public function getTypes(ContentTypeEnum $contentTypeEnum): array;
}
