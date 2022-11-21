<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\Available;

interface AvailableTypeInterface
{
    public function getAvailable(): array;
}
