<?php

namespace Sody;

use Sody\IoC;
use Sody\System;
use Sody\Http\Response;
use Sody\View\View;
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

    public function view($view, $data = array())
    {
        $view = new View($view, $data);

        return $this->response($view);
    }

    public function response($data, $headers = array())
    {
        $response = new Response($data, $headers);

        return $response->send();
    }

    public function version()
    {
        return SODY_VERSION;
    }

    public function on($event, $callback)
    {
        $this->ioC->resolve('event')->on($event, $callback);
    }

    public function trigger($event)
    {
        return $this->ioC->resolve('event')->trigger($event);
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
