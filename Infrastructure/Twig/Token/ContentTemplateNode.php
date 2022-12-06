<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token;

use Twig\Compiler;
use Twig\Node\Node;

class ContentTemplateNode extends Node
{
    /**
     * {@inheritdoc}
     */
    public function compile(Compiler $compiler): void
    {
        $compiler->addDebugInfo($this);

        $compiler
            ->write('$this->loadTemplate(')
            ->repr('@CmsDefaultTheme/content_template/ourservices.html.twig') // need to generate from contentTemplateName
            ->raw(', ')
            ->repr($this->getTemplateName())
            ->raw(', ')
            ->repr($this->getTemplateLine())
            ->raw(')')
            ->raw('->display(')
            ->raw('twig_array_merge($context,')
            ->raw('["name" => "value"])') // need to generate from contentTemplate fields
            ->raw(');')
        ;
    }
}
