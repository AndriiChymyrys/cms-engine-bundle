<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\DataSource;

use WideMorph\Cms\Bundle\CmsEngineBundle\Presentation\Form\Type\PageFormType;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Page\CreatePageServiceInterface;
use WideMorph\Morph\Bundle\MorphCoreBundle\Interaction\Contract\DataSource\CreateDataSourceInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Bridge\MorphCore\FormDataSourceDefinitionInterfaceBridge;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Bridge\MorphCore\CreateDataSourceDefinitionInterfaceBridge;

/**
 * Class CreatePageDataSource
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Domain\DataSource
 */
class CreatePageDataSource implements CreateDataSourceDefinitionInterfaceBridge, FormDataSourceDefinitionInterfaceBridge
{
    /**
     * @param CreatePageServiceInterface $createPageService
     */
    public function __construct(protected CreatePageServiceInterface $createPageService)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getSource(): CreateDataSourceInterface
    {
        return $this->createPageService;
    }

    /**
     * {@inheritDoc}
     */
    public function getForm(): string
    {
        return PageFormType::class;
    }

    /**
     * {@inheritDoc}
     */
    public function getFormOptions(): array
    {
        return [];
    }
}
