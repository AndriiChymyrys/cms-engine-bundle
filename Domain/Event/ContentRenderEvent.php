<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Event;

use Symfony\Contracts\EventDispatcher\Event;

class ContentRenderEvent extends Event
{
    /** @var string */
    public const NAME = 'cms.content.render';

    /**
     * @param mixed $value
     * @param array|null $configs
     */
    public function __construct(protected mixed $value, protected ?array $configs = [])
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

    /**
     * @return array|null
     */
    public function getConfigs(): ?array
    {
        return $this->configs;
    }

    /**
     * @param array $configs
     */
    public function setConfigs(array $configs): void
    {
        $this->configs = $configs;
    }
}
