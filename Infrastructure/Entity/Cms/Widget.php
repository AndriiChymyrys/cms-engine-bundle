<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms;

use Doctrine\ORM\Mapping as ORM;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\ThemeAwareTrait;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\ProviderThemeTrait;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\LayoutAwareTrait;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\TimestampAbleEntityTrait;

/**
 * Class Widget
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms
 * !!hasLifecycleCallbacks
 * !!repositoryClass App\Repository\Cms\WidgetRepository
 */
class Widget
{
    use TimestampAbleEntityTrait;
    use ProviderThemeTrait;
    use LayoutAwareTrait;
    use ThemeAwareTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    protected mixed $id = null;

    /**
     * @ORM\Column(name="type", type="string")
     */
    protected string $type;

    /**
     * @ORM\Column(name="config", type="json", nullable=true, options={"jsonb"=true})
     */
    protected array $config;

    /**
     * @ORM\Column(name="widget_order", type="integer", options={"default" : 1})
     */
    protected int $order = 1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cms\Content", inversedBy="widgets")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id")
     */
    protected Content|null $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function setConfig(?array $config): self
    {
        $this->config = $config;

        return $this;
    }

    public function getContent(): ?Content
    {
        return $this->content;
    }

    public function setContent(?Content $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int $order
     *
     * @return $this
     */
    public function setOrder(int $order): self
    {
        $this->order = $order;

        return $this;
    }

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
     * @return $this
     */
    public function setProvideTheme(string $provideTheme): self
    {
        $this->provideTheme = $provideTheme;

        return $this;
    }
}
