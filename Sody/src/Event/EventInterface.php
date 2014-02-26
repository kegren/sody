<?php

namespace Sody\Event;

interface EventInterface
{
    /**
     * Adds an event to the stack
     *
     * @param  string  $event
     * @param  closure $callback
     * @return Sody\Event
     */
    public function on($name, $callback);

    /**
     * Triggers an event by its name
     *
     * @param  string  $event
     * @return Callable
     */
    public function trigger($name);
}
