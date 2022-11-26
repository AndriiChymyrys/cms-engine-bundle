<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\Available;

interface AvailableTypeInterface
{
    /**
     * @return array<string, array<string, string>>
     */
    public function getAvailable(): array;
}
