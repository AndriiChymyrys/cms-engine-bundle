<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token;

use Twig\Compiler;
use Twig\Node\Node;

/**
 * Class ContentNode
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token
 */
class ContentNode extends Node
{
    /**
     * {@inheritdoc}
     */
    public function compile(Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        $compiler->raw(PHP_EOL)
            ->write(
                sprintf('if ($contentRender->hasContent($blockName, "%s", $pageRender)) {', $this->getAttribute('name'))
            )
            ->write(PHP_EOL)
            ->write(
                sprintf('echo $contentRender->getContent($blockName, "%s", $pageRender);', $this->getAttribute('name'))
            )
            ->write(PHP_EOL)
            ->write('} else {')
            ->write(PHP_EOL)
            ->subcompile($this->getNode('defaultContent'))
            ->write(PHP_EOL)
            ->write('}')
            ->write(PHP_EOL);
    }
}
