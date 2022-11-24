<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Routing;

use App\Entity\Cms\Page;
use Symfony\Component\Routing\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouteCollection;
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
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        protected string $frontController,
        protected EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getRouteCollection(): RouteCollection
    {
        $collection = new RouteCollection();
        $repository = $this->entityManager->getRepository(Page::class);

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
