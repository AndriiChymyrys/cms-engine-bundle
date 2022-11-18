<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\Type;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeProviderRegistryInterface;

class AvailableFieldType implements AvailableTypeInterface
{
    public function __construct(protected ThemeProviderRegistryInterface $providerRegistry)
    {
    }

    public function getAvailable(): array
    {
        $availableFields = [];

        foreach ($this->providerRegistry->all() as $themeProvider) {
            foreach ($themeProvider->getFields() as $field) {
                if (!isset($availableFields[$themeProvider->getName()])) {
                    $availableFields[$themeProvider->getName()] = [];
                }

                $availableFields[$themeProvider->getName()][$field->getType()] = $field->getName();
            }
        }

        return $availableFields;
    }
}
