<?php

namespace Sody\Http\Session;

/**
 * SessionInterface
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
interface SessionInterface
{
    public function set($name, $value);
    public function get($name);
    public function flush($name);
    public function flushAll();
    public function getAll();
    public function isStarted();
}
