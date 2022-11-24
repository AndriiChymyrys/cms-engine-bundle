<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum;

use App\Entity\Cms\{FieldType\JsonType,
    FieldType\TextType,
    FieldType\StringType,
    FieldType\IntegerType,
    FieldType\DateTimeType
};

enum DatabaseFieldTypeEnum: string
{
    case DATETIME = 'datetime';
    case INTEGER = 'integer';
    case JSON = 'json';
    case STRING = 'string';
    case TEXT = 'text';

    public function getEntityClass(): string
    {
        return match ($this) {
            self::DATETIME => DateTimeType::class,
            self::INTEGER => IntegerType::class,
            self::JSON => JsonType::class,
            self::STRING => StringType::class,
            self::TEXT => TextType::class,
        };
    }
}
