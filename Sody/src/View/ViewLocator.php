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
    private $extension = '.php';

    public function __construct($paths = array(), $extension = '.php')
    {
        $this->paths = $paths;
        $this->extension = $extension;
    }

    private function buildPath($view, $path = null)
    {
        // append php if not already appended
        if (substr($view, -4) != '.php') {
            $view = $view . $this->extension;
        }

        $path = rtrim($path, '/') . '/';

        return $path ? $path . $view : $view;
    }

    public function exists($view)
    {
        if ($this->paths) {
            foreach ($this->paths as $path) {
                $file = $this->buildPath($view, $path);

                if (file_exists($file)) {
                    return $file;
                }
            }
        } else {
            $file = $this->buildPath($view);

            if (file_exists($file)) {
                return $file;
            }
        }
    }
}
