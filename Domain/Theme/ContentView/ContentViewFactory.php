<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\ContentTypeEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Exception\ThemeProviderException;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ContentView\View\ContentViewTypeInterface;

class ContentViewFactory implements ContentViewFactoryInterface
{
    public function __construct(protected array $views)
    {
    }

    public function getContentView(ContentTypeEnum $contentType): ContentViewTypeInterface
    {
        if (isset($this->views[$contentType->value])) {
            return $this->views[$contentType->value];
        }

        throw new ThemeProviderException(sprintf('Can not build edit view for contentType "%s"', $contentType->value));
    }
}
