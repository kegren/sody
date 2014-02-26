<?php

namespace Sody\Http\Session\Engine;

use Sody\Http\Session\Engine;

/**
 * Native PHP session
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class PhpNative implements SessionEngineInterface
{
    private $name;
    private $storageDir;

    public function isStarted()
    {
        if (version_compare(phpversion(), '5.4.0', '>=')) {
            return session_status() == PHP_SESSION_ACTIVE;
        };

        return session_id() and isset($_SESSION);
    }

    public function start()
    {
        if (false === $this->isStarted()) {

            if (false === session_start()) {
                throw new RuntimeException('Error while resolving session_start');
            }
        }
    }

    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function setStorageDir($dir)
    {
        $this->storageDir = (string) $dir;

        session_save_path($this->storageDir);
    }

    public function set($name, $value)
    {
        $_SESSION[(string) $name] = $value;

        return $this;
    }

    public function get($name)
    {
        if (isset($_SESSION[(string) $name])) {
            return $_SESSION[$name];
        }
    }

    public function has($name)
    {
        if (null !== $this->get($name)) {
            return true;
        }
    }

    public function getAll()
    {
        return $_SESSION;
    }

    public function flush($name)
    {
        if ($this->has($name)) {
            unset($_SESSION[$name]);
            return true;
        }
    }

    /**
     * Destroys session in browser, in filesystem
     * and remove from session array
     *
     * @return void
     */
    public function flushAll()
    {
        if (isset($_COOKIE[session_name($this->name)])) {
            setcookie(session_name($this->name), '', time()-3600, '/');
        }

        session_unset();
        // deletes session file
        session_destroy();
    }
}
