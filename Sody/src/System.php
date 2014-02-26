<?php

namespace Sody;

use Sody\IoC;
use Sody\Exception\SodyException;
use Sody\Event\Event;
use Sody\Http\Request;
use Sody\Http\Response;
use Sody\Routing\Router;
use Sody\Routing\Route;
use Sody\Routing\RouteStorage;
use Sody\Routing\RouteDispatcher;
use Sody\View\View;
use Sody\View\Adapter\PhpNative;
use Sody\Logging\Adapter\TextFile;
use Sody\Logging\Log;
use ArrayAccess;

/**
 * The heart and soul of Sody
 *
 * @author Kenny Damgren <kennydamgren@gmail.com>
 * @package Sody
 */
abstract class System implements ArrayAccess
{
    /**
     * Current version
     */
    const SODY_VERSION = '0.x.x';

    /**
     * Version type
     */
    const SODY_VERSION_TYPE = 'pre-alpha';

    /**
     * @var Sody\IoC
     */
    protected $ioC = null;

    /**
     * @var array
     */
    protected $config = array();

    protected $route;

    protected $view;

    public function __construct(IoC $ioC = null)
    {
        $this->ioC = $ioC ?: new IoC;

        // resolve config in isolation
        $config = (function ($config) {
            $file = SODY_CONFIG_PATH . 'app.php';

            if (file_exists($file)) {
                require $file;
            }
        });

        $config($this);

        date_default_timezone_set($this['timezone']);

        $this->registerBaseComponents();
        #$this->registerBaseErrorHandling();
        $this->registerBaseEvents();

        $this->setRoute($this->ioC->resolve('route'));
        #$this->setView($this->ioC->resolve('view'));
    }

    public function setView(View $view)
    {
        $this->view = $view;
    }

    public function getView()
    {
        return $this->view;
    }

    public function setRoute(Route $route)
    {
        $this->route = $route;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function resolve($service)
    {
        return $this->ioC->resolve($service);
    }

    public function offsetSet($offset, $value)
    {
        if (null === $offset) {
            $this->config[] = $value;
        } else {
            $this->config[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->config[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->config[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->config[$offset]) ? $this->config[$offset] : null;
    }

    private function registerBaseErrorHandling()
    {
        $handler = $this->ioC->resolve('error');

        if (true == $this['config']) {
            // PHP error handler
            set_error_handler(array($handler, 'development'));
            // PHP exceptions error handler
            set_exception_handler(array($handler, 'development'));
            // PHP fatal error
            register_shutdown_function(array($handler, 'development'));
            // PHP error reporting
            error_reporting(-1);

            return;
        }

        // PHP error handler
        set_error_handler(array($handler, 'production'));
        // PHP exceptions error handler
        set_exception_handler(array($handler, 'production'));
        // PHP fatal error
        register_shutdown_function(array($handler, 'production'));
        // PHP error reporting
        error_reporting(0);
    }

    private function registerBaseEvents()
    {
        $this->ioC->resolve('event')->on('start.sody', function () {
            echo "hold on tight, this can get dirty. But hopefully not.";
        });
    }

    /**
     * Registers all base components needed for
     * Sody to run.
     *
     * @return void
     */
    private function registerBaseComponents()
    {
        $self = $this;
        $ioC = $this->ioC;

        $this->ioC->event = $this->ioC->shared(function () use ($self) {
            return new Event();
        });

        $this->ioC->route = function () use ($ioC) {
            $route = new Route(null, null, null);

            return new RouteStorage($route);
        };

        $this->ioC->request = function () use ($self) {
            $request = new Request();
            $request->setBaseUrl($self['baseUrl']);

            return $request;
        };

        $this->ioC->dispatcher = function () use ($self, $ioC) {
            $route = $self->getRoute();
            $request = $ioC->resolve('request');

            return new RouteDispatcher($request, $route);
        };

        $this->ioC->router = function () use ($ioC) {
            return new Router($ioC->resolve('request'));
        };

        $this->ioC->log = $this->ioC->shared(function () {
            $adapter = new TextFile();

            return new Log($adapter);
        });
    }
}
