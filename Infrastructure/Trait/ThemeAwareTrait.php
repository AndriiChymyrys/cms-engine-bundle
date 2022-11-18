<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait;

use Doctrine\ORM\Mapping as ORM;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Field;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Widget;

trait ThemeAwareTrait
{
    /**
     * @ORM\Column(name="theme", type="string")
     */
    protected string $theme;

    /**
     * @ORM\Column(name="layout", type="string")
     */
    protected string $layout;

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
     * @return Widget|Field|ThemeAwareTrait
     */
    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLayout(): ?string
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     *
     * @return Widget|Field|ThemeAwareTrait
     */
    public function setLayout(string $layout): self
    {
        $this->layout = $layout;

        return $this;
    }
}
