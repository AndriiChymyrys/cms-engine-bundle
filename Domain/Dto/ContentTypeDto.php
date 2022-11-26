<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Dto;

class ContentTypeDto
{
    public string $contentType;
    public string $contentKey;
    public int|null $id;
    public bool $saved;
    public mixed $value;
    public array $configs;
    public int $order;

    public function __construct(array $data)
    {
        $this->contentType = $data['contentType'] ?? '';
        $this->contentKey = $data['contentKey'] ?? '';
        $this->id = $data['id'] ?? null;
        $this->saved = $data['saved'] ?? false;
        $this->value = $data['value'] ?? null;
        $this->configs = $data['configs'] ?? [];
        $this->order = $data['order'] ?? 1;
    }
}
