<?php

namespace Sody\Logging;

use Sody\Logging\Adapter\LogAdapterInterface;

/**
 * Logger
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class Log
{
    /**
     * @var Sody\Logging\Adapter\LogAdapterInterface
     */
    private $adapter;

    /**
     * Constructor sets adapter
     *
     * @param Sody\Logging\Adapter\LogAdapterInterface $adapter
     */
    public function __construct(LogAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function write($message, $file = null)
    {
        return $this->adapter->write($message, $file);
    }

    public function read($file = null)
    {
        return $this->adapter->read($file);
    }

    public function clear()
    {
        return $this->adapter->clear();
    }
}
