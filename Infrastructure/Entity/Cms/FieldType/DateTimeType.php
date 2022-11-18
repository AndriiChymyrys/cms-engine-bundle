<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\FieldType;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Field;

class DateTimeType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    protected mixed $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cms\Field")
     * @ORM\JoinColumn(name="field_id", referencedColumnName="id")
     */
    protected Field $field;

    /**
     * @ORM\Column(name="value", type="datetime", nullable=false)
     */
    protected DateTimeInterface $value;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Field|null
     */
    public function getField(): ?Field
    {
        return $this->field;
    }

    /**
     * @param Field|null $field
     *
     * @return $this
     */
    public function setField(?Field $field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getValue(): ?DateTimeInterface
    {
        return $this->value;
    }

    /**
     * @param DateTimeInterface $value
     *
     * @return $this
     */
    public function setValue(DateTimeInterface $value): self
    {
        $this->value = $value;

        return $this;
    }
}
