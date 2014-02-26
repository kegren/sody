<?php

namespace Sody\Exception;

use Exception;
use Sody\View\View;
use Sody\Logging\Log;

/**
 * Sody exception
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
class SodyException extends Exception
{
    /**
     * @var string
     */
    private $viewFile = 'exception.php';
    /**
     * @var Sody\View\View
     */
    private $view = null;

    /**
     * @var Sody\Logging\Log
     */
    private $log = null;
    /**
     * @var string
     */
    private $filePath = '';

    /**
     * Constructor sets View
     *
     * @param Sody\View\View $view
     */
    public function __construct(View $view = null, Log $log = null)
    {
        if (null !== $view) {
            $this->view = $view;
        }

        if (null !== $log) {
            $this->log = $log;
        }

        $this->filePath = $this->buildPath();
    }

    public function development()
    {
        $args  = func_get_args();
        $trace = debug_backtrace();

        #return $this->view->show(self::VIEW_PATH . self::VIEW_FILE, $args);
    }

    public function production()
    {
        $args = func_get_args();
        $trace = debug_backtrace();
    }

    protected function buildPath()
    {
        $current = __DIR__;

        return $current . '/View/' . $this->viewFile;
    }
}
