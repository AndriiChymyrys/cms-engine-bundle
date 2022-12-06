<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\Publish;

use SplFileInfo;
use FilesystemIterator;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Symfony\Component\Filesystem\Filesystem;

class PublishFileManager implements PublishFileManagerInterface
{
    /**
     * @param Filesystem $filesystem
     */
    public function __construct(protected Filesystem $filesystem)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function copyRecursive(string $from, string $to): void
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($from, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        $to = rtrim($to, DIRECTORY_SEPARATOR);

        if (!$this->filesystem->exists($to)) {
            $this->filesystem->mkdir($to);
        }

        /** @var SplFileInfo $item */
        foreach ($iterator as $item) {
            $toPath = $to . DIRECTORY_SEPARATOR . $iterator->getSubPathname();

            if ($item->isDir()) {
                $this->filesystem->mkdir($toPath);
            } else {
                $this->filesystem->copy($item->getPathname(), $toPath);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function copyTemplate(string $from, string $to): void
    {
        $to = rtrim($to, DIRECTORY_SEPARATOR);

        if (!$this->filesystem->exists($to)) {
            $this->filesystem->mkdir($to);
        }

        $templateName = basename($from);

        $this->filesystem->copy($from, $to . DIRECTORY_SEPARATOR. $templateName);
    }
}
