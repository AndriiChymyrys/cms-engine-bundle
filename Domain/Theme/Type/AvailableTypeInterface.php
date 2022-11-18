<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\Type;

interface AvailableTypeInterface
{
    public function getAvailable(): array;
}
