<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract;

interface WidgetProviderInterface
{
    public function getName(): string;

    public function getType(): string;
}
