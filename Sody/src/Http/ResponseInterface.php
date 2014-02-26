<?php

namespace Sody\Http;

interface ResponseInterface
{
    const DEFAULT_PROTOCOL = 'HTTP/1.1';

    public function send();
    public function isHeaderSent();

    public function setBody($body);
    public function getBody();
    public function setHeaders(array $headers = array());
    public function getHeaders();
    public function setStatusCode($code);
    public function getStatusCode();
    public function setProtocol($protocol);
    public function getProtocol();
}
