<?php

namespace Sody\Http;

use Sody\Http\ResponseInterface;

/**
 * Response
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class Response implements ResponseInterface
{
    private $status = 200;
    private $body = '';
    private $headers = array();

    private $statusCodes = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Moved Temporarily',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported'
    );

    public function __construct(
        $body = '',
        $status = 200,
        $headers = array(),
        $protocol = self::DEFAULT_PROTOCOL
    ) {
        $this->setBody($body);
        $this->setStatusCode($status);
        $this->setHeaders($headers);
        $this->setProtocol($protocol);
    }

    public function isHeaderSent()
    {
        return headers_sent();
    }

    public function send()
    {
        $this->sendHeader();

        return $this->sendBody();
    }

    public function sendHeader()
    {
        if ($this->isHeaderSent()) {
            return;
        }

        $message = $this->statusCodes[$this->status];

        header($message, true, $this->status);

        if (null !== $headers = $this->getHeaders()) {
            foreach ($headers as $type => $value) {
                header("{$type}: {$value}");
            }
        }
    }

    public function sendBody()
    {
        echo $this->body;
    }

    public function setBody($body = '')
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setStatusCode($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatusCode()
    {
        return $this->status;
    }

    public function setHeaders(array $headers = array())
    {
        $headers = array_filter($headers, 'strlen');

        if (!empty($headers)) {
            foreach ($headers as $type => $value) {
                $this->headers[$type] = $value;
            }
        }
    }

    public function getHeaders()
    {
        if (!empty($this->headers)) {
            return $this->headers;
        }
    }

    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;

        return $this;
    }

    public function getProtocol()
    {
        return $this->protocol;
    }

    public function __toString()
    {
        return (string) $this->body;
    }
}
