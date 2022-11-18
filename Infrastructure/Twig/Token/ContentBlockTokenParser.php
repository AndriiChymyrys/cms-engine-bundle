<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token;

use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class ContentBlockTokenParser extends AbstractTokenParser
{
    /**
     * {@inheritDoc}
     *
     * It is wrapper for startcontent
     */
    public function parse(Token $token)
    {
        $lineNumber = $token->getLine();
        $stream = $this->parser->getStream();

        $name = $stream->expect(Token::NAME_TYPE)->getValue();

        $stream->expect(Token::BLOCK_END_TYPE);
        $block = $this->parser->subparse([$this, 'decideCacheEnd'], true);
        $stream->expect(Token::BLOCK_END_TYPE);

        return new ContentBlockNode(['block' => $block], ['name' => $name], $lineNumber, $this->getTag());
    }

    /**
     * @param Token $token
     *
     * @return bool
     */
    public function decideCacheEnd(Token $token)
    {
        return $token->test('endcontentblock');
    }

    /**
     * {@inheritDoc}
     */
    public function getTag()
    {
        return 'contentblock';
    }
}
