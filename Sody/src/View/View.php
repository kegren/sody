<?php

namespace Sody\View;

use Sody\View\ViewLocator;

/**
 * Sody view
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class View
{
    private $view;
    private $data = array();
    private $layout;
    private $partials = array();
    private $paths = array();

    /**
     * Constructor with view and data params
     *
     * @param string $view
     * @param array  $data
     */
    public function __construct($view = null, $data = array())
    {
        $this->view = $view;
        $this->data = $data;
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function __get($key)
    {
        return isset($this->data[$key])
               ? $this->data[$key]
               : null;
    }

    private function includeFile($view)
    {
        return include $view;
    }

    private function exists()
    {
        $locator = new ViewLocator($this->paths);

        return $locator->exists($this->view);
    }

    public function render($view = null, $data = array())
    {
        $view = (null === $view) ? $this->view : $view;
        $this->data = empty($data)
                    ? $this->data
                    : array_merge($this->data, $data);

        if (null !== $view = $this->exists()) {

            foreach ($this->data as $key => $value) {
                $this->{$key} = $value;
            }

            extract($this->data);

            ob_start();

            $this->includeFile($view);

            return ob_get_clean();
        }
    }

    public function show($view = null, $data = array())
    {
        echo $this->render($view, $data);
    }

    public function __toString()
    {
        return $this->render();
    }
}
