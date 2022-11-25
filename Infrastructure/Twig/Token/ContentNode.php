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
                sprintf('$content = $contentRender->getContent($blockName, "%s", $pageRender);', $this->getAttribute('name'))
            )
            ->write(PHP_EOL)
            ->write('if ($content) {')
            ->write(PHP_EOL)
            ->indent()->write('foreach ($contentRender->renderTypes($content, $pageRender) as $content) {')
            ->write(PHP_EOL)
            ->indent()->write('echo $content;')
            ->write(PHP_EOL)
            ->outdent()->write('}')
            ->write(PHP_EOL)
            ->outdent()->write('} else {')
            ->write(PHP_EOL)
            ->indent()->subcompile($this->getNode('defaultContent'))
            ->write(PHP_EOL)
            ->outdent()->write('}')
            ->write(PHP_EOL);
    }
}
