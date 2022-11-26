<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Event;

use Symfony\Contracts\EventDispatcher\Event;

class BeforeContentRenderEvent extends Event
{
    /** @var string */
    public const NAME = 'cms.content.before_render';

    /**
     * @param mixed $value
     */
    public function __construct(protected mixed $value)
    {
    }

    /**
     * @param mixed $value
     *
     * @return void
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}
