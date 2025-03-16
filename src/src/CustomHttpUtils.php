<?php

namespace App;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Security\Http\HttpUtils;

class CustomHttpUtils extends HttpUtils
{
    public function __construct(
        private string $vkRedirectUri,
        ?UrlGeneratorInterface $urlGenerator = null,
        private UrlMatcherInterface|RequestMatcherInterface|null $urlMatcher = null,
        ?string $domainRegexp = null,
        ?string $secureDomainRegexp = null
    ){
        parent::__construct($urlGenerator, $urlMatcher, $domainRegexp, $secureDomainRegexp);
    }

    /**
     * @inheritDoc
     */
    public function checkRequestPath(Request $request, string $path): bool
    {
        if ($this->vkRedirectUri === $path) {
            $pathInfo = explode('/', $path);

            $pathInfo = array_slice($pathInfo, 3);

            $pathInfo = '/' . implode('/', $pathInfo);

            if ($pathInfo === $request->getPathInfo()) {
                return true;
            }
        }

        if ('/' !== $path[0]) {
            // Shortcut if request has already been matched before
            if ($request->attributes->has('_route')) {
                return $path === $request->attributes->get('_route');
            }

            try {
                // matching a request is more powerful than matching a URL path + context, so try that first
                if ($this->urlMatcher instanceof RequestMatcherInterface) {
                    $parameters = $this->urlMatcher->matchRequest($request);
                } else {
                    $parameters = $this->urlMatcher->match($request->getPathInfo());
                }

                return isset($parameters['_route']) && $path === $parameters['_route'];
            } catch (MethodNotAllowedException|ResourceNotFoundException) {
                return false;
            }
        }

        return $path === rawurldecode($request->getPathInfo());
    }
}