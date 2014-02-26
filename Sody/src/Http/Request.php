<?php

namespace Sody\Http;

/**
 * HTTP Request
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class Request
{
    protected $server = null;
    protected $baseUrl = null;

    public function __construct($server = null)
    {
        $this->server = null === $server ? $_SERVER : $server;
    }

    public function getPath()
    {
        return null === $this->get('path_info') ? $this->get('request_uri') : $this->get('path_info');
    }

    public function setBaseUrl($url)
    {
        return $this->baseUrl = $url;
    }

    public function is($method)
    {
        return $method == $this->getMethod();
    }

    public function getQueryString()
    {
        return $this->server['QUERY_STRING'];
    }

    public function getMethod()
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function isMethod($method, $current = null)
    {
        $method = strtoupper($method);

        if (null === $current) {
            return $method == $this->get($method);
        }

        return $method == strtoupper($current);
    }

    public function has($key)
    {
        return isset($this->server[strtoupper($key)]);
    }

    public function get($key)
    {
        $key = strtoupper($key);

        if (isset($this->server[$key])) {
            return $this->server[$key];
        }
    }
}
