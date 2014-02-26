<?php

namespace Sody\View;

use Sody\View\View;

/**
 * Sody composite view
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class CompositeView
{
    /**
     * @var array
     */
    private $views = array();

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
