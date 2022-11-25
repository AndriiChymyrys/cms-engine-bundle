<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\FieldType;

use Doctrine\ORM\Mapping as ORM;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Field;

class IntegerType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    protected mixed $id = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cms\Field")
     * @ORM\JoinColumn(name="field_id", referencedColumnName="id")
     */
    protected Field $field;

    /**
     * @ORM\Column(name="value", type="integer", nullable=false)
     */
    protected int $value;

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
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setValue(string $value): self
    {
        $this->value = (int)$value;

        return $this;
    }
}
