<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait;

use Doctrine\ORM\Mapping as ORM;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Field;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Widget;

trait ProviderThemeTrait
{
    /**
     * @ORM\Column(name="provide_theme", type="string")
     */
    protected string $provideTheme;

    /**
     * @return string
     */
    public function getProvideTheme(): string
    {
        return $this->provideTheme;
    }

    /**
     * @param string $provideTheme
     *
     * @return Widget|Field|ProviderThemeTrait
     */
    public function setProvideTheme(string $provideTheme): self
    {
        $this->provideTheme = $provideTheme;

        return $this;
    }
}
