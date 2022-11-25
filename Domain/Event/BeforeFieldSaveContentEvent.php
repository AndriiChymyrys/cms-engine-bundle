<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class BeforeFieldSaveContentEvent
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Event
 */
class BeforeFieldSaveContentEvent extends Event
{
    /** @var string */
    public const NAME = 'cms.field.before_save';

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
    public function setValue(mixed $value)
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
