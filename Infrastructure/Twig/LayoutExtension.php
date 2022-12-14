<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig;

use Twig\Extension\AbstractExtension;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\DomainInteractionInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token\ContentTokenParser;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token\ContentBlockTokenParser;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token\ContentTemplateTokenParser;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token\ContentTemplateFieldTokenParser;

class LayoutExtension extends AbstractExtension
{
    public function __construct(protected DomainInteractionInterface $domainInteraction)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getTokenParsers(): array
    {
        return [
            new ContentBlockTokenParser(),
            new ContentTokenParser(),
            new ContentTemplateTokenParser(),
            new ContentTemplateFieldTokenParser(),
        ];
    }
}
