<?php

namespace Sody\Http;

/**
 * Response header
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class ResponseHeader
{
    /**
     * @var array
     */
    private $headers = array();

    /**
     * Returns true if key exists else false
     *
     * @param  string  $key
     * @return boolean
     */
    private function has($key)
    {
        return isset($this->headers[$key]);
    }

    /**
     * Sets a new header
     *
     * @param string $key
     * @param string $value
     */
    public function set($key, $value)
    {
        $this->headers[$key] = $value;

        return $this;
    }

    /**
     * Returns a header if exists
     *
     * @param  string $key
     * @return string|null
     */
    public function get($key)
    {
        if ($this->has($key)) {
            return $this->headers[$key];
        }
    }
}
