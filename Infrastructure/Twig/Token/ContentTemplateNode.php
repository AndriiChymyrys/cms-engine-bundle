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

        $name = str_replace('.', DIRECTORY_SEPARATOR, $this->getAttribute('name'));

        $compiler
            ->write('$this->loadTemplate(')
            ->raw('$context["render"]->getPathResolver()->getFullPublicFileName(')
            ->raw(PHP_EOL)
            ->raw('$context["render"]->getThemeProvider()->getName(), ')
            ->raw(PHP_EOL)
            ->raw('\WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\TemplatePathResolverInterface::THEME_CONTENT_TEMPLATE_TYPE, ')
            ->raw(PHP_EOL)
            ->raw(sprintf('"%s", ', $name))
            ->raw(PHP_EOL)
            ->raw('), ')
            ->raw(PHP_EOL)
            ->repr($this->getTemplateName())
            ->raw(', ')
            ->raw(PHP_EOL)
            ->repr($this->getTemplateLine())
            ->raw(')')
            ->raw('->display(twig_array_merge($context, ')
            ->raw(sprintf('["contentTemplateName" => "%s"]', $this->getAttribute('name')))
            ->raw('));')
        ;
    }
}
