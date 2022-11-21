<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum;

use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\FieldType\JsonType;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\FieldType\TextType;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\FieldType\StringType;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\FieldType\IntegerType;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\FieldType\DateTimeType;

enum DatabaseFieldTypeEnum: string
{
    case DATETIME = 'datetime';
    case INTEGER = 'integer';
    case JSON = 'json';
    case STRING = 'string';
    case TEXT = 'text';

    public function getEntityClass(): string
    {
        return match($this) {
            self::DATETIME => DateTimeType::class,
            self::INTEGER => IntegerType::class,
            self::JSON => JsonType::class,
            self::STRING => StringType::class,
            self::TEXT => TextType::class,
        };
    }

    public function getEntityResolverName(): string
    {
        return match($this) {
            self::DATETIME => 'Cms/FieldType/DateTimeType',
            self::INTEGER => 'Cms/FieldType/IntegerType',
            self::JSON => 'Cms/FieldType/JsonType',
            self::STRING => 'Cms/FieldType/StringType',
            self::TEXT => 'Cms/FieldType/TextType',
        };
    }
}
