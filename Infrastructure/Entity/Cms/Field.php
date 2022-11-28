<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms;

use Doctrine\ORM\Mapping as ORM;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\ThemeAwareTrait;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\ProviderThemeTrait;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\LayoutAwareTrait;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\TimestampAbleEntityTrait;

/**
 * Class Field
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms
 * !!repositoryClass App\Repository\Cms\FieldRepository
 * !!hasLifecycleCallbacks
 */
class Field
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
     * @ORM\Column(name="db_type", type="string")
     */
    protected string $dbType;

    /**
     * @ORM\Column(name="config", type="json", nullable=true, options={"jsonb"=true})
     */
    protected array|null $config = null;

    /**
     * @ORM\Column(name="field_order", type="integer", options={"default" : 1})
     */
    protected int $order = 1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cms\Content", inversedBy="fields")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id")
     */
    protected Content|null $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cms\ContentTemplate", inversedBy="fields")
     * @ORM\JoinColumn(name="content_template_id", referencedColumnName="id")
     */
    protected ContentTemplate|null $contentTemplate;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Content|null
     */
    public function getContent(): ?Content
    {
        return $this->content;
    }

    /**
     * @param Content|null $content
     *
     * @return $this
     */
    public function setContent(?Content $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return ContentTemplate|null
     */
    public function getContentTemplate(): ?ContentTemplate
    {
        return $this->contentTemplate;
    }

    /**
     * @param ContentTemplate|null $contentTemplate
     *
     * @return $this
     */
    public function setContentTemplate(?ContentTemplate $contentTemplate): self
    {
        $this->contentTemplate = $contentTemplate;

        return $this;
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

    /**
     * @return string|null
     */
    public function getDbType(): ?string
    {
        return $this->dbType;
    }

    /**
     * @param string $dbType
     *
     * @return $this
     */
    public function setDbType(string $dbType): self
    {
        $this->dbType = $dbType;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getConfig(): ?array
    {
        return $this->config;
    }

    /**
     * @param array|null $config
     *
     * @return $this
     */
    public function setConfig(?array $config): self
    {
        $this->config = $config;

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
     * @param int|null $order
     *
     * @return $this
     */
    public function setOrder(?int $order): self
    {
        $this->order = $order;

        return $this;
    }
}
