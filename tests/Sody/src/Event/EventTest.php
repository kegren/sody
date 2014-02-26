<?php

use Sody\Event\Event;

class EventTest extends PHPUnit_Framework_TestCase
{
    public function testAddEvent()
    {
        $e = new Event();
        $e->on(
            'test',
            function () {
                echo 'Hello World!';
            }
        );
    }

    public function testTriggerEvent()
    {
        $e = new Event();
        $e->on(
            'test',
            function () {
                return 'Hello World!';
            }
        );

        $this->assertEquals('Hello World!', $e->trigger('test'));
    }
}
