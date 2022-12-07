<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Layout;

use Twig\Environment;
use Twig\Node\ModuleNode;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token\ContentNode;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token\ContentBlockNode;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\TemplatePathResolverInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token\ContentTemplateNode;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token\ContentTemplateFieldNode;

class TwigLayoutService implements TwigLayoutServiceInterface
{
    /**
     * @param Environment $environment
     * @param TemplatePathResolverInterface $templatePathResolver
     */
    public function __construct(
        protected Environment $environment,
        protected TemplatePathResolverInterface $templatePathResolver,
    ) {
    }

    /**
     * {@inheritDoc}
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\SyntaxError
     */
    public function getContentBlocks(Page $page): array
    {
        $tokens = $this->getTwigTokens($page, TemplatePathResolverInterface::THEME_LAYOUT_TYPE);

        return $this->walkNodesBlock($tokens->getNode('blocks')->getNode('layout_body')->getIterator());
    }

    /**
     * {@inheritDoc}
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\SyntaxError
     */
    public function getContentTemplates(Page $page): array
    {
        $tokens = $this->getTwigTokens($page, TemplatePathResolverInterface::THEME_LAYOUT_TYPE);

        return $this->walkContentTemplateNodes($tokens->getNode('blocks')->getNode('layout_body')->getIterator());
    }

    public function getContentTemplateFields(Page $page, string $contentTemplateName): array
    {
        $tokens = $this->getTwigTokens($page, TemplatePathResolverInterface::THEME_CONTENT_TEMPLATE_TYPE, $contentTemplateName);

        return $this->walkContentTemplateFieldNodes($tokens->getIterator());
    }

    /**
     * @param Page $page
     * @param string $templateType
     * @param string|null $contentTemplateName
     *
     * @return ModuleNode
     * @throws LoaderError
     * @throws SyntaxError
     */
    protected function getTwigTokens(Page $page, string $templateType, ?string $contentTemplateName = null)
    {
        $templatePath = $this->templatePathResolver->getFullPublicFileName(
            $page->getTheme(),
            $templateType,
            $contentTemplateName ?: $page->getLayout(),
        );

        return $this->environment->parse(
            $this->environment->tokenize(
                $this->environment->getLoader()->getSourceContext($templatePath)
            )
        );
    }

    /**
     * @param iterable $nodes
     * @param array $blocks
     *
     * @return array
     *
     * @throws \Exception
     */
    protected function walkNodesBlock(iterable $nodes, array $blocks = []): array
    {
        foreach ($nodes as $node) {
            if ($node instanceof ContentBlockNode) {
                // walk through children content blocks
                $blocks[$node->getAttribute('name')] = [
                    'contents' => $this->walkNodesBlock($node->getIterator()),
                    'parent' => null,
                    'main' => true,
                ];

                // walk through inner ContentBlockNode and fetch them on first array level get rid of nested
                foreach ($blocks[$node->getAttribute('name')]['contents'] as $key => $value) {
                    if (isset($value['main'])) {
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
                $blocks[$node->getAttribute('name')] = [];
            } else {
                $blocks = $this->walkNodesBlock($node->getIterator(), $blocks);
            }
        }

        return $blocks;
    }

    /**
     * @param iterable $nodes
     * @param array $blocks
     *
     * @return array
     *
     * @throws \Exception
     */
    protected function walkContentTemplateNodes(iterable $nodes, array $blocks = []): array
    {
        foreach ($nodes as $node) {
            if ($node instanceof ContentTemplateNode) {
                $blocks[$node->getAttribute('name')] = [];
            } else {
                $blocks = $this->walkContentTemplateNodes($node->getIterator(), $blocks);
            }
        }

        return $blocks;
    }

    protected function walkContentTemplateFieldNodes(iterable $nodes, array $blocks = []): array
    {
        foreach ($nodes as $node) {
            if ($node instanceof ContentTemplateFieldNode) {
                $blocks[$node->getAttribute('name')] = [];
            } else {
                $blocks = $this->walkContentTemplateFieldNodes($node->getIterator(), $blocks);
            }
        }

        return $blocks;
    }
}
