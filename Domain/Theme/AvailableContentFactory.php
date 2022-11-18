<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\ContentTypeEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Exception\ThemeProviderException;

class AvailableContentFactory implements AvailableContentFactoryInterface
{
    public function __construct(protected array $contentTypes)
    {
    }


    public function getContents(ContentTypeEnum $contentTypeEnum): array
    {
        if (isset($this->contentTypes[$contentTypeEnum->value])) {
            return $this->contentTypes[$contentTypeEnum->value]->getAvailable();
        }

        throw new ThemeProviderException(sprintf('Not found available types for type "%s"', $contentTypeEnum->name));
    }
}
