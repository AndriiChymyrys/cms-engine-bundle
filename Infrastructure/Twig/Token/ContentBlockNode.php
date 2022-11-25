<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token;

use Twig\Compiler;
use Twig\Node\Node;

class ContentBlockNode extends Node
{
    /**
     * {@inheritdoc}
     */
    public function compile(Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        $compiler->raw(PHP_EOL)
            ->write(sprintf('$%s = function () use ($context) {', $this->getAttribute('name')))
            ->raw(PHP_EOL)
            ->indent()->write(sprintf('$blockName = "%s";', $this->getAttribute('name')))
            ->raw(PHP_EOL)
            ->write('$contentRender = $this->env->getGlobals()["content_render"];')
            ->raw(PHP_EOL)
            ->write('$pageRender = $context["render"];');

        // compile from ContentNode
        $compiler->subcompile($this->getNode('block'))->outdent();

        $compiler->write('};');
        $compiler->write(sprintf('$%s();', $this->getAttribute('name')));
    }
}
