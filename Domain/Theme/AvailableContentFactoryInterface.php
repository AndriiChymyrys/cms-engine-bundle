<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\ContentTypeEnum;

interface AvailableContentFactoryInterface
{
    public function getContents(ContentTypeEnum $contentTypeEnum): array;
}
