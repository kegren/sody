<?php

namespace Sody\Http\Session;

use Sody\Http\Session\Engine\SessionEngineInterface;
use Sody\Http\Session\Engine\PhpNative;

/**
 * Session
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class Session
{
    private $engine;

    public function __construct(SessionEngineInterface $engine = null)
    {
        $this->engine = $engine === null ? new PhpNative() : $engine;
    }

    public function setFlash($name, $value)
    {
        $this->set($name, $value);

        return $this;
    }

    public function getFlash($name)
    {
        if ($this->has($name)) {
            $flash = $this->get($name);
            $this->flush($name);

            return $flash;
        }
    }

    public function isStarted()
    {
        return $this->engine->isStarted();
    }

    public function start()
    {
        return $this->engine->start();
    }

    public function set($name, $value)
    {
        $this->engine->set($name, $value);

        return $this;
    }

    public function has($name)
    {
        return $this->engine->has($name);
    }

    public function get($name)
    {
        return $this->engine->get($name);
    }

    public function getAll()
    {
        return $this->engine->getAll();
    }

    public function flush($name)
    {
        return $this->engine->flush($name);
    }

    public function flushAll()
    {
        return $this->engine->flushAll();
    }
}
