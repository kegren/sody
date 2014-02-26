<?php

namespace Sody\Routing;

use Sody\Http\Request;
use Sody\Routing\RouteStorage;
use Sody\Exception\NoRouteFoundException;

/**
 * Route dispatcher
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class RouteDispatcher
{
    /**
     * @var Sody\Http\Request
     */
    private $request;
    /**
     * @var Sody\Routing\RouteStorage
     */
    private $storage;

    /**
     * Constructor sets Request and RouteStorage
     *
     * @param Request $request
     * @param RouteStorage $storage
     */
    public function __construct(Request $request, RouteStorage $storage)
    {
        $this->request = $request;
        $this->storage = $storage;
    }

    /**
     * Dispatches a request. Begins by checking if
     * match was found and if found we can safetly
     * resolve its route
     *
     * @return resolved
     */
    public function dispatch()
    {
        $route = $this->match($this->request->getPath());

        if (null === $route) {
            throw new NoRouteFoundException("No route found for given url");
        }

        return $this->resolve($route);
    }

    /**
     * Resolves a route by calling its
     * callback and send any params
     *
     * @param  array $route
     * @return mixed
     */
    private function resolve($route)
    {
        $callback = $route['callback'];

        if (!is_callable($callback)) {
            throw new InvalidMethodException('Route must be callable current type is: ' . gettype($callback));
        }

        return $callback();

        return call_user_func_array($route['callback'], $route['parameters']);
    }

    /**
     * Matches current uri against routes
     * in storage.
     *
     * @param  string $uri
     * @return mixed
     */
    private function match($uri)
    {
        $routes = $this->storage->getRoutes();

        if (!empty($routes)) {
            foreach ($routes as $route) {
                $method = $route['method'];

                if ($this->request->is($method)) {
                    $resolved = $this->resolveRoute($route, $uri);

                    // no regular expression just return the route
                    if (true === $resolved) {
                        return $route;
                    }

                    if ($uri == $resolved['resolvedUri']) {
                        return array_merge($resolved, $route);
                    }
                }
            }
        }
    }

    /**
     * Resolves current route.
     *
     * @param  string $uri
     * @return mixed
     */
    private function resolveRoute($route, $uri)
    {
        $routeUri = $route['route'];

        if ($routeUri == $uri) {
            return true;
        }

        if (preg_match_all("#^$routeUri$#", $uri, $values)) {
            $resolvedUri = array_shift($values);
            $resolvedUri = reset($resolvedUri);

            $parameters = array_map(function ($ele) {
                return $ele[0];
            }, $values);

            return compact('resolvedUri', 'parameters');
        }
    }
}
