<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Layout;

use Twig\Environment;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token\ContentNode;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token\ContentBlockNode;

class TwigLayoutService implements TwigLayoutServiceInterface
{
    public function __construct(protected Environment $environment)
    {
    }

    public function getContentBlocks(Page $page): array
    {
        $tokens = $this->environment->parse(
            $this->environment->tokenize(
                $this->environment->getLoader()->getSourceContext($page->getLayout())
            )
        );

        return $this->walkNodes($tokens->getNode('blocks')->getNode('layout_body')->getIterator());
    }

    protected function walkNodes(iterable $nodes, array $blocks = []): array
    {
        foreach ($nodes as $node) {
            if ($node instanceof ContentBlockNode) {
                // walk through children content blocks
                $blocks[$node->getAttribute('name')] = [
                    'contents' => $this->walkNodes($node->getIterator()),
                    'parent' => null,
                ];

                // walk through inner ContentBlockNode and fetch them on first array level get rid of nested
                foreach ($blocks[$node->getAttribute('name')]['contents'] as $key => $value) {
                    if (is_array($value)) {
                        $blocks[$key] = $value;
                        if ($blocks[$key]['parent'] === null) {
                            // check if parent was set before, only set parent if it is null
                            $blocks[$key]['parent'] = $node->getAttribute('name');
                        }
                        unset($blocks[$node->getAttribute('name')]['contents'][$key]);
                    }
                }
            } elseif ($node instanceof ContentNode) {
                // get content block name
                $blocks[] = $node->getAttribute('name');
            } else {
                $blocks = $this->walkNodes($node->getIterator(), $blocks);
            }
        }

        return $blocks;
    }
}
