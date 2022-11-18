<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token;

use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * Class ContentTokenParser
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Twig\Token
 */
class ContentTokenParser extends AbstractTokenParser
{
    /**
     * {@inheritDoc}
     *
     * This token should be embedded in contentblock
     *
     * Example of use:
     *      {% contentblock contactBlock %}
     *          {% startcontent email %}default@mail.com{% endcontent %}
     *      {% endcontentblock %}
     *
     * Description:
     *      {% startcontent email %}default@mail.com{% endcontent %}
     *          email - is content name
     *          default@mail.com - is a default value if page does not have 'email' content for contactBlock
     */
    public function parse(Token $token)
    {
        $lineNumber = $token->getLine();
        $stream = $this->parser->getStream();

        $name = $stream->expect(Token::NAME_TYPE)->getValue();

        $stream->expect(Token::BLOCK_END_TYPE);
        $defaultContent = $this->parser->subparse([$this, 'decideCacheEnd'], true);
        $stream->expect(Token::BLOCK_END_TYPE);

        return new ContentNode(
            ['defaultContent' => $defaultContent],
            ['name' => $name],
            $lineNumber,
            $this->getTag()
        );
    }

    /**
     * @param Token $token
     *
     * @return bool
     */
    public function decideCacheEnd(Token $token)
    {
        return $token->test('endcontent');
    }

    /**
     * {@inheritDoc}
     */
    public function getTag()
    {
        return 'startcontent';
    }
}
