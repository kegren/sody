<?php

namespace Sody\Event;

/**
 * Event
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class Event implements EventInterface
{
    /**
     * @var array
     */
    private $events = array();

    /**
     * Adds an event to the stack
     *
     * @param  string  $event
     * @param  closure $callback
     * @return Sody\Event
     */
    public function on($event, $callback)
    {
        $this->events[$event] = $callback;

        return $this;
    }

    /**
     * Triggers an event by its name
     *
     * @param  string  $event
     * @return Callable
     */
    public function trigger($event)
    {
        if (array_key_exists($event, $this->events)) {
            if (is_callable($this->events[$event])) {
                return $this->events[$event]($this);
            }
        }
    }

    /**
     * Removes an event
     *
     * @param  string $event
     * @return void
     */
    public function remove($event)
    {
        if (array_key_exists($event, $this->events)) {
            unset($this->events[$event]);
        }
    }
}
