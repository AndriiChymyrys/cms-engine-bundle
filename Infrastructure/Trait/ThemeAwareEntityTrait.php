<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait;

use Doctrine\ORM\Mapping as ORM;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Field;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Widget;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\ContentBlock;

trait ThemeAwareEntityTrait
{
    /**
     * @ORM\Column(name="theme", type="string")
     */
    protected string $theme;

    /**
     * @return string|null
     */
    public function getTheme(): ?string
    {
        return $this->theme;
    }

    /**
     * @param string $theme
     *
     * @return Page|ContentBlock|Field|Widget|ThemeAwareEntityTrait
     */
    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }
}
