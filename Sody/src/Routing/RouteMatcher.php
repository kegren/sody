<?php

namespace Sody\Routing;

/**
 * Route matcher
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class RouteMatcher
{
    public function isMatch($uri, $route)
    {
        if (strcasecmp($uri, $route) == 0) {
            return true;
        }

        if (preg_match("#{$route}#", $uri)) {
            return true;
        }
    }

    public function match($uri, $route)
    {
        preg_match_all("#{$route}#", $uri, $matches);

        $matches = array_filter($matches, 'strlen');
    }

    public function matchMultiple($uri, array $routes = array())
    {
        foreach ($routes as $route) {
            if ($this->isMatch($uri, $route)) {
                return true;
            }
        }
    }
}
