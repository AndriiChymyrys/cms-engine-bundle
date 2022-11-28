<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Event;

use Symfony\Contracts\EventDispatcher\Event;

class BeforeContentTypeSaveEvent extends Event
{
    /** @var string */
    public const NAME = 'cms.before_save';

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
     * @return ?array
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
