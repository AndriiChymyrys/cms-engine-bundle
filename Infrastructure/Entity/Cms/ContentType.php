<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms;

use App\Entity\Cms\Field;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\TimestampAbleEntityTrait;

/**
 * Class ContentType
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms
 * !!hasLifecycleCallbacks
 */
class ContentType
{
    use TimestampAbleEntityTrait;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Cms\Field", mappedBy="contentType")
     */
    protected Collection $fields;

    public function __construct()
    {
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
            $field->setContentType($this);
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
            if ($field->getContentType() === $this) {
                $field->setContentType(null);
            }
        }

        return $this;
    }
}
