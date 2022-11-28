<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\PageRenderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\DomainInteractionInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token\ContentTokenParser;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token\ContentBlockTokenParser;

class LayoutExtension extends AbstractExtension
{
    public function __construct(protected DomainInteractionInterface $domainInteraction)
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('content_type_assets', [$this, 'getContentTypeAssets'])
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getTokenParsers()
    {
        return [
            new ContentBlockTokenParser(),
            new ContentTokenParser(),
        ];
    }

    public function getContentTypeAssets(string $blockName, PageRenderInterface $pageRender)
    {

    }
}
