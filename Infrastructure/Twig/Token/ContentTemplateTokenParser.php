<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token;

use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class ContentTemplateTokenParser extends AbstractTokenParser
{
    /**
     * {@inheritDoc}
     */
    public function parse(Token $token)
    {
        $lineNumber = $token->getLine();
        $stream = $this->parser->getStream();

        $name = $stream->expect(Token::NAME_TYPE)->getValue();

        $stream->expect(Token::BLOCK_END_TYPE);
        $defaultContentBlock = $this->parser->subparse([$this, 'decideCacheEnd'], true);
        $stream->expect(Token::BLOCK_END_TYPE);

        return new ContentTemplateNode(
            ['block' => $defaultContentBlock],
            ['name' => $name],
            $lineNumber,
            $this->getTag());
    }

    /**
     * @param Token $token
     *
     * @return bool
     */
    public function decideCacheEnd(Token $token)
    {
        return $token->test('endcontenttemplate');
    }

    /**
     * {@inheritDoc}
     */
    public function getTag()
    {
        return 'contenttemplate';
    }
}
