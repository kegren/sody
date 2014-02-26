<?php

namespace Sody\View;

/**
 * Sody view locator
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class ViewLocator
{
    private $paths = array();
    private $extension;

    public function __construct($paths = array(__DIR__), $extension = '.php')
    {
        $this->paths = $paths;
        $this->extension = $extension;
    }

    private function buildPath($view, $path)
    {
        $path = rtrim($path, '/') . '/';

        return $path . $view . $this->extension;
    }

    public function exists($view)
    {
        $this->paths = array(__DIR__ . '/../../../');

        if (!empty($this->paths)) {
            foreach ($this->paths as $path) {
                $file = $this->buildPath($view, $path);

                if (file_exists($file)) {
                    return $file;
                }
            }
        }
    }
}
