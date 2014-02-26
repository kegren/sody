<?php

namespace Sody\Routing;

/**
 * Route base
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class Route
{
    /**
     * @var array
     */
    private $patterns = array(
        '{id}'     => '(\d+)',
        '{num}'    => '(\d+)',
        '{action}' => '([\w\_\-\%]+)',
        '{any}'    => '([\w\_\-\%]+)'
    );

    private $name;
    private $method;
    private $route;
    private $callback;

    /**
     * Constructor sets RouteStorage
     *
     * @param RouteStorage $storage
     */
    public function __construct($method = null, $name = null, $route = null, $callback = null)
    {
        $this->setMethod($method);
        $this->setName($name);
        $this->setRoute($route);
        $this->setCallback($callback);
    }

    /**
     * Replaces placeholder against regex
     *
     * @param  string  $route
     * @return string
     */
    private function regexRoute($route)
    {
        foreach ($this->patterns as $prefix => $pattern) {
            $route = str_replace($prefix, $pattern, $route);
        }

        return $route;
    }

    public function setName($name)
    {
        $this->name = strtolower($name);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setMethod($method)
    {
        $this->method = strtoupper($method);
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setRoute($route)
    {
        $route = $this->regexRoute($route);

        $this->route = $route;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function setCallback($callback)
    {
        $this->callback = $callback;
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function getStorage()
    {
        return $this->storage;
    }
}
