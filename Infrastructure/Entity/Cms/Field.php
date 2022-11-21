<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms;

use Doctrine\ORM\Mapping as ORM;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\ThemeAwareTrait;
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
    use ThemeAwareTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    protected mixed $id;

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
    protected array $config;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cms\Content", inversedBy="fields")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id")
     */
    protected Content|null $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cms\ContentType", inversedBy="fields")
     * @ORM\JoinColumn(name="content_type_id", referencedColumnName="id")
     */
    protected ContentType|null $contentType;

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
     * @return ContentType|null
     */
    public function getContentType(): ?ContentType
    {
        return $this->contentType;
    }

    /**
     * @param ContentType|null $contentType
     *
     * @return $this
     */
    public function setContentType(?ContentType $contentType): self
    {
        $this->contentType = $contentType;

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
     * @return array
     */
    public function getConfig(): array
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
}
