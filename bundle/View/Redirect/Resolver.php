<?php

declare(strict_types=1);

namespace Netgen\Bundle\EzPlatformSiteApiBundle\View\Redirect;

use Netgen\Bundle\EzPlatformSiteApiBundle\View\ContentView;
use Netgen\EzPlatformSiteApi\API\Values\Content;
use Netgen\EzPlatformSiteApi\API\Values\Location;
use Symfony\Component\Routing\RouterInterface;

final class Resolver
{
    /**
     * @var \Netgen\Bundle\EzPlatformSiteApiBundle\QueryType\ParameterProcessor
     */
    private $parameterProcessor;

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * Resolver constructor.
     *
     * @param \Netgen\Bundle\EzPlatformSiteApiBundle\View\Redirect\ParameterProcessor $parameterProcessor
     * @param \Symfony\Component\Routing\RouterInterface $router
     */
    public function __construct(
        ParameterProcessor $parameterProcessor,
        RouterInterface $router
    ) {
        $this->parameterProcessor = $parameterProcessor;
        $this->router = $router;
    }

    /**
     * Builds a path to the redirect target.
     *
     * @param \Netgen\Bundle\EzPlatformSiteApiBundle\View\Redirect\RedirectConfiguration $redirectConfig
     * @param \Netgen\Bundle\EzPlatformSiteApiBundle\View\ContentView $view
     *
     * @return string
     */
    public function resolveTarget(RedirectConfiguration $redirectConfig, ContentView $view): string
    {
        $value = $this->parameterProcessor->process(
            $redirectConfig->getTarget(),
            $view
        );

        if ($value instanceof Location || $value instanceof Content) {
            return $this->router->generate(
                $value,
                $redirectConfig->getTargetParameters()
            );
        }

        return '/';
    }
}
