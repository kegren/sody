<?php

namespace Sody;

use Sody\IoC;
use Sody\AppAbstract;
use Sody\System;
use BadMethodCallException;

/**
 * The App acts as a simple facade for Sody Framework.
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class App extends System implements AppInterface
{
    public function start()
    {
        $dispatcher = $this->ioC->resolve('dispatcher');
        $event = $this->ioC->resolve('event');

        $event->trigger('sody.start');
        $event->trigger('on.before.start');

        $dispatch = $dispatcher->dispatch();

        $event->trigger('sody.end');
        $event->trigger('on.after.start');
    }

    public function show($view, $data = array())
    {
        return $this->view->show($view, $data);
    }

    public function version()
    {
        return SODY_VERSION;
    }

    public function on($event, $callback)
    {
        $this->resolve('event')->on($event, $callback);
    }

    public function trigger($event)
    {
        return $this->resolve('event')->trigger($event);
    }

    public function register($class, $callback)
    {
        $this->ioC->register($class, $callback);
    }

    public function get($name, $route, $callback)
    {
        $this->route->add('GET', $name, $route, $callback);
    }

    public function post($name, $route, $callback)
    {
        $this->route->add('POST', $name, $route, $callback);
    }

    public function put($name, $route, $callback)
    {
        $this->route->add('PUT', $name, $route, $callback);
    }

    public function delete($name, $route, $callback)
    {
        $this->route->add('DELETE', $name, $route, $callback);
    }
}