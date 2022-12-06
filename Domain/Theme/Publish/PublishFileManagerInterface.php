<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\Publish;

interface PublishFileManagerInterface
{
    /**
     * @param string $from
     * @param string $to
     *
     * @return void
     */
    public function copyRecursive(string $from, string $to): void;

    /**
     * @param string $from
     * @param string $to
     *
     * @return void
     */
    public function copyTemplate(string $from, string $to): void;
}
