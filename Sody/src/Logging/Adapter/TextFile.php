<?php

namespace Sody\Logging\Adapter;

use Sody\Logging\Adapter\LogAdapterInterface;

/**
 * Regular text file logging
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class TextFile implements LogAdapterInterface
{
    private $extension = '.txt';
    private $file = 'log.txt';
    private $dir = SODY_STORAGE_LOG_PATH;
    private $format = "[%s] -> %s \n";

    public function __construct($file = null, $dir = null)
    {
        if (null !== $file) {
            $this->file = $file;
        }

        if (null !== $dir) {
            $this->dir = $dir;
        }
    }

    public function write($message, $file = null)
    {
        if (null !== $file) {
            $this->file = $file;
        }

        $file = $this->getPath();

        $date = date('Y-m-d/h:i:s');

        $message = sprintf($this->format, $date, $message);

        // append to end of file and secure for override
        file_put_contents($file, $message, FILE_APPEND | LOCK_EX);
    }

    public function read($file = null)
    {
        if (null !== $file) {
            $this->file = $file;
        }

        $file = $this->getPath();

        $content = file_get_contents($file);

        return explode("\n", $content);
    }

    public function clear()
    {
        $file = $this->getPath();

        if (true === $this->exists($file)) {
            file_put_contents($file, "");

            return true;
        }
    }

    private function getPath()
    {
        return $this->dir . $this->file;
    }

    private function exists($file)
    {
        return file_exists($file);
    }
}
