<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Presentation\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\DomainInteractionInterface;

/**
 * Class IndexController
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Presentation\Controller\Front
 */
class IndexController extends AbstractController
{
    /**
     * @param Request $request
     * @param DomainInteractionInterface $domainInteraction
     *
     * @return Response
     */
    public function index(Request $request, DomainInteractionInterface $domainInteraction): Response
    {
        return $this->render(
            '@CmsEngine/front/index/index.html.twig',
            ['render' => $domainInteraction->getPageRenderFactory()->getPageRender($request->attributes->all())]
        );
    }
}
