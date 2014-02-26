<?php

namespace Sody;

use Sody\Exception\ServiceAlreadyRegisterException;
use Sody\Exception\NoServiceFoundException;
use Closure;

/**
 * Inversion of Control container
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class IoC
{
    /**
     * @var array
     */
    private $services = array();

    /**
     * Registers an service to the container
     *
     * @param  string  $name
     * @param  closure $callback
     * @param  boolean $shared
     * @return void
     */
    public function register($key, Closure $callback, $shared = false)
    {
        $key = ucfirst($key);

        if (false === $this->has($key)) {

            if (true === $shared) {
                $callback = $this->shared($callback);

                return $this->services[$key] = $callback;
            }

            return $this->services[$key] = $callback;
        }

        throw new ServiceAlreadyRegisterException("IoC: A service with name $key is already registered");
    }

    public function unregister($key)
    {
        $key = ucfirst($key);

        if (isset($this->services[$key])) {
            unset($this->services[$key]);
        }
    }

    public function resolve($key, $params = array())
    {
        $key = ucfirst($key);

        if ($this->has($key)) {
            $service = $this->services[$key];

            if (is_callable($service)) {
                return $service($this);
            }
        }

        throw new NoServiceFoundException("IoC: No service was found with key $key");
    }

    public function __set($key, $callback)
    {
        $key = ucfirst($key);

        $this->services[$key] = $callback;
    }

    public function shared($callable)
    {
        return function ($c) use ($callable) {
            static $resolver;

            if (null === $resolver) {
                $resolver = $callable($c);
            }

            return $resolver;
        };
    }

    public function listAll()
    {
        return $this->services;
    }

    public function has($key)
    {
        return isset($this->services[ucfirst($key)]);
    }

    public function clean()
    {
        $this->services = array();
    }
}
