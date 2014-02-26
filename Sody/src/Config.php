<?php

namespace Sody;

use ArrayAccess;

class Config implements ArrayAccess
{
    private $config = array();

    public function __construct()
    {
        $get = function ($config) {
            $file = SODY_CONFIG_PATH . 'app' . self::CONFIG_EXTENSION;

            if (file_exists($file)) {
                require $file;
            }
        };

        $get($this);
    }

    public function offsetSet($offset, $value)
    {
        if (null === $offset) {
            $this->config[] = $value;
        } else {
            $this->config[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->config[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->config[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->config[$offset]) ? $this->config[$offset] : null;
    }
}
