<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\DatabaseFieldTypeEnum;

interface FieldProviderInterface
{
    public const DATABASE_FIELD_TYPE_DATETIME = DatabaseFieldTypeEnum::DATETIME;
    public const DATABASE_FIELD_TYPE_INTEGER = DatabaseFieldTypeEnum::INTEGER;
    public const DATABASE_FIELD_TYPE_JSON = DatabaseFieldTypeEnum::JSON;
    public const DATABASE_FIELD_TYPE_STRING = DatabaseFieldTypeEnum::STRING;
    public const DATABASE_FIELD_TYPE_TEXT = DatabaseFieldTypeEnum::TEXT;

    public function getName(): string;

    public function getType(): string;

    public function getEditView(mixed $value): string;

    public function getPageView(): string;

    public function getDatabaseType(): DatabaseFieldTypeEnum;
}
