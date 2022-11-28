<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait;

use Doctrine\ORM\Mapping as ORM;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Field;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Widget;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\ContentBlock;

trait LayoutAwareEntityTrait
{
    /**
     * @ORM\Column(name="layout", type="string")
     */
    protected string $layout;

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
     * @return Page|ContentBlock|Field|Widget|LayoutAwareEntityTrait
     */
    public function setLayout(string $layout): self
    {
        $this->layout = $layout;

        return $this;
    }
}
