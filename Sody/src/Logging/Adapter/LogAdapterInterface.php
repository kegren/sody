<?php

namespace Sody\Logging\Adapter;

/**
 * @package Sody
 */
interface LogAdapterInterface
{
    public function write($message, $file = null);
    public function read($file = null);
    public function clear();
}
