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

    public function __construct($paths = array(), $extension = '.php')
    {
        $this->paths = $paths;
        $this->extension = $extension;
    }

    private function buildPath($view, $path = null)
    {
        if (null === $path) {
            return $view . $this->extension;
        } else {
            $path = rtrim($path, '/') . '/';

            return $path . $view . $this->extension;
        }
    }

    public function exists($view)
    {
        if (!empty($this->paths)) {
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
