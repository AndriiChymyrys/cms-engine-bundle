<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Routing;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\Page;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\RouteParameterEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\MorphCoreInteractionInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Bridge\MorphRouting\RouterProviderInterfaceBridge;

/**
 * Class RouteProvider
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Routing
 */
class RouteProvider implements RouterProviderInterfaceBridge
{
    /**
     * @param string $frontController
     * @param MorphCoreInteractionInterface $morphCoreInteraction
     */
    public function __construct(
        protected string $frontController,
        protected MorphCoreInteractionInterface $morphCoreInteraction
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getRouteCollection(): RouteCollection
    {
        $collection = new RouteCollection();
        $repository = $this->morphCoreInteraction->getEntityResolver()->getEntityRepository('Cms/Page');

        /** @var Page $page */
        foreach ($repository->findAll() as $page) {
            $collection->add($this->getRouteName($page), $this->getRoute($page));
        }

        return $collection;
    }

    /**
     * @param Page $page
     *
     * @return Route
     */
    protected function getRoute(Page $page): Route
    {
        return new Route(path: $page->getUrl(), defaults: [
            RouteParameterEnum::PAGE->value => $page,
            RouteParameterEnum::CONTROLLER->value => $this->frontController,
        ]);
    }

    /**
     * @param Page $page
     *
     * @return string
     */
    protected function getRouteName(Page $page): string
    {
        return sprintf('cms_page_%s', str_replace(' ', '_', $page->getName()));
    }
}
