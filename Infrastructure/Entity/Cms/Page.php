<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Cms\ContentBlock;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\PageStatusEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\ThemeAwareTrait;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Trait\TimestampAbleEntityTrait;

/**
 * Class Page
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity
 * !!repositoryClass App\Repository\Cms\PageRepository
 * !!hasLifecycleCallbacks
 */
class Page
{
    use TimestampAbleEntityTrait;
    use ThemeAwareTrait;

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
     * @ORM\Column(name="url", type="string")
     */
    protected string $url;

    /**
     * @ORM\Column(name="layout", type="string")
     */
    protected string $layout;

    /**
     * @ORM\Column(name="status", type="string", length=10)
     */
    protected string $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cms\ContentBlock", mappedBy="page")
     */
    protected Collection $contentBlocks;

    public function __construct()
    {
        $this->contentBlocks = new ArrayCollection();
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
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

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
     * @return $this
     */
    public function setLayout(string $layout): self
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param PageStatusEnum $status
     *
     * @return $this
     */
    public function setStatus(PageStatusEnum $status): self
    {
        $this->status = $status->value;

        return $this;
    }

    /**
     * @return Collection<int, ContentBlock>
     */
    public function getContentBlocks(): Collection
    {
        return $this->contentBlocks;
    }

    /**
     * @param ContentBlock $contentBlock
     *
     * @return $this
     */
    public function addContentBlock(ContentBlock $contentBlock): self
    {
        if (!$this->contentBlocks->contains($contentBlock)) {
            $this->contentBlocks->add($contentBlock);
            $contentBlock->setPage($this);
        }

        return $this;
    }

    /**
     * @param ContentBlock $contentBlock
     *
     * @return $this
     */
    public function removeContentBlock(ContentBlock $contentBlock): self
    {
        if ($this->contentBlocks->removeElement($contentBlock)) {
            // set the owning side to null (unless already changed)
            if ($contentBlock->getPage() === $this) {
                $contentBlock->setPage(null);
            }
        }

        return $this;
    }

    public function getVueData(): array
    {
        return [
            'id' => $this->getId(),
        ];
    }
}
