<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms;

use App\Entity\Cms\Field;
use App\Entity\Cms\Widget;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\TimestampAbleEntityTrait;

/**
 * Class Content
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms
 * !!hasLifecycleCallbacks
 * !!repositoryClass App\Repository\Cms\ContentRepository
 */
class Content
{
    use TimestampAbleEntityTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    protected mixed $id = null;

    /**
     * @ORM\Column(name="name", type="string")
     */
    protected string $name;

    /**
     * @ORM\Column(name="type", type="string")
     */
    protected string $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cms\ContentBlock", inversedBy="contents")
     * @ORM\JoinColumn(name="content_block_id", referencedColumnName="id")
     */
    protected ContentBlock|null $contentBlock = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cms\Widget", mappedBy="content")
     */
    protected Collection $widgets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cms\Field", mappedBy="content")
     */
    protected Collection $fields;

    public function __construct()
    {
        $this->widgets = new ArrayCollection();
        $this->fields = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

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
     * @return ContentBlock|null
     */
    public function getContentBlock(): ?ContentBlock
    {
        return $this->contentBlock;
    }

    /**
     * @param ContentBlock|null $contentBlock
     *
     * @return $this
     */
    public function setContentBlock(?ContentBlock $contentBlock): self
    {
        $this->contentBlock = $contentBlock;

        return $this;
    }

    /**
     * @return Collection<int, Widget>
     */
    public function getWidgets(): Collection
    {
        return $this->widgets;
    }

    /**
     * @param Widget $widget
     *
     * @return $this
     */
    public function addWidget(Widget $widget): self
    {
        if (!$this->widgets->contains($widget)) {
            $this->widgets->add($widget);
            $widget->setContent($this);
        }

        return $this;
    }

    /**
     * @param Widget $widget
     *
     * @return $this
     */
    public function removeWidget(Widget $widget): self
    {
        if ($this->widgets->removeElement($widget)) {
            // set the owning side to null (unless already changed)
            if ($widget->getContent() === $this) {
                $widget->setContent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Field>
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }

    /**
     * @param Field $field
     *
     * @return $this
     */
    public function addField(Field $field): self
    {
        if (!$this->fields->contains($field)) {
            $this->fields->add($field);
            $field->setContent($this);
        }

        return $this;
    }

    /**
     * @param Field $field
     *
     * @return $this
     */
    public function removeField(Field $field): self
    {
        if ($this->fields->removeElement($field)) {
            // set the owning side to null (unless already changed)
            if ($field->getContent() === $this) {
                $field->setContent(null);
            }
        }

        return $this;
    }
}
