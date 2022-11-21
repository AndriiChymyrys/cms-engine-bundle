<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms;

use App\Entity\Cms\Content;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\TimestampAbleEntityTrait;

/**
 * Class ContentBlock
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms
 * !!hasLifecycleCallbacks
 */
class ContentBlock
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
     * @ORM\OneToMany(targetEntity="App\Entity\Cms\Content", mappedBy="contentBlock")
     */
    protected Collection $contents;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cms\Page", inversedBy="contentBlocks")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     */
    protected Page|null $page = null;

    public function __construct()
    {
        $this->contents = new ArrayCollection();
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
     * @return Collection<int, Content>
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }

    /**
     * @param Content $content
     *
     * @return $this
     */
    public function addContent(Content $content): self
    {
        if (!$this->contents->contains($content)) {
            $this->contents->add($content);
            $content->setContentBlock($this);
        }

        return $this;
    }

    /**
     * @param Content $content
     *
     * @return $this
     */
    public function removeContent(Content $content): self
    {
        if ($this->contents->removeElement($content)) {
            // set the owning side to null (unless already changed)
            if ($content->getContentBlock() === $this) {
                $content->setContentBlock(null);
            }
        }

        return $this;
    }

    /**
     * @return Page|null
     */
    public function getPage(): ?Page
    {
        return $this->page;
    }

    /**
     * @param Page|null $page
     *
     * @return $this
     */
    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }
}
