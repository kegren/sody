<?php

namespace Sody\Http\Session\Engine;

/**
 * SessionEngineInterface
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
interface SessionEngineInterface
{
    public function set($name, $value);
    public function get($name);
    public function setStorageDir($dir);
    public function setName($name);
    public function start();
    public function isStarted();
    public function has($name);
}
