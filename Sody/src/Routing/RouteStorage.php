<?php

namespace Sody\Routing;

use Sody\Routing\Route;

/**
 * Route storage
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class RouteStorage
{
    /**
     * @var array
     */
    protected $routes = array();

    public function add($method, $name, $route, $callback)
    {
        $route = $this->setRoute($method, $name, $route, $callback);

        return $this->store($route);
    }

    public function store(Route $obj)
    {
        $method = $obj->getMethod();
        $name = $obj->getName();
        $route = $obj->getRoute();
        $callback = $obj->getCallback();

        return $this->routes[] = compact('method', 'name', 'route', 'callback');
    }

    public function setRoute($method, $name, $type, $callback)
    {
        return new Route($method, $name, $type, $callback);
    }

    /**
     * Returns true if route exists otherwise
     * null
     *
     * @param  string  $route
     * @return boolean
     */
    public function has($route)
    {
        if (array_key_exists($route, $this->routes)) {
            return true;
        }
    }

    /**
     * Returns a specific route if specified
     * otherwise returns all
     *
     * @param  string $route
     * @return string|array
     */
    public function get($route = null)
    {
        if (null !== $route) {
            if (true === $this->has($route)) {
                return $this->routes;
            }
        }
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}
