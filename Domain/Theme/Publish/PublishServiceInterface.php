<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\Publish;

interface PublishServiceInterface
{
    /**
     * @param string|null $themeName
     *
     * @return void
     */
    public function publish(?string $themeName = null): void;
}
