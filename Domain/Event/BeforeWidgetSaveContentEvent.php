<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Event;

class BeforeWidgetSaveContentEvent
{
    /** @var string */
    public const NAME = 'cms.widget.before_save';

    /**
     * @param array $configs
     */
    public function __construct(protected array $configs)
    {
    }

    /**
     * @return array
     */
    public function getConfigs(): array
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
