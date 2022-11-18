<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms;

use Doctrine\ORM\Mapping as ORM;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\ThemeAwareTrait;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\TimestampAbleEntityTrait;

/**
 * Class Widget
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms
 * !!hasLifecycleCallbacks
 */
class Widget
{
    use TimestampAbleEntityTrait;
    use ThemeAwareTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    protected mixed $id;

    /**
     * @ORM\Column(name="name", type="string")
     */
    protected string $name;

    /**
     * @ORM\Column(name="config", type="json", nullable=true, options={"jsonb"=true})
     */
    protected array $config;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cms\Content", inversedBy="contents")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id")
     */
    protected Content|null $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
}
