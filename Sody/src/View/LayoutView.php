<?php

namespace Sody\View;

use Sody\View\View;

/**
 * Sody view
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class LayoutView
{
    private $views = array();
    private $content = null;

    public function add(View $view)
    {
        $this->views[] = $view;

        return $this;
    }

    public function remove(View $view)
    {
        if (in_array($view, $this->views)) {
            unset($this->views[$view]);
        }

        return $this;
    }

    public function render()
    {
        $content = '';

        foreach ($this->views as $view) {
            $content .= $view->render();
        }

        return $content;
    }

    public function __toString()
    {
        return $this->render();
    }
}
