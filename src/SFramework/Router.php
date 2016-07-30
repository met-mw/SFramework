<?php
namespace SFramework;


use Exception;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use InvalidArgumentException;
use SFileSystem\Directory;

class Router implements RouterInterface
{

    /** @var Directory|null */
    protected $root = null;
    /** @var Uri|null */
    protected $uri = null;

    /**
     * Router constructor.
     * @param string $root
     * @param Uri $uri
     */
    public function __construct($root, Uri $uri)
    {
        $this->setRoot($root)
            ->setURI($uri);
    }

    /**
     * Find controller
     *
     * @param string[] $pathParts
     * @return ControllerInterface
     * @throws Exception
     */
    public function findController(array &$pathParts)
    {
        $root = $this->root;

        if (sizeof($pathParts) == 0) {
            $controllerName = str_replace('/', '\\', $root->getPath()) . '\\ControllerIndex';
        } else {
            $controllerName = '';

            $previousPart = null;
            while ($part = array_shift($pathParts)) {
                $previousPart = $part;
                $root->scan();
                $dir = $root->getDirectory(ucfirst($part));
                if (!is_null($dir)) {
                    $oldRoot = clone $root;
                    $root = $dir;
                    if (empty($pathParts)) {
                        $file = $root->getFile('ControllerIndex.php');
                        if (!is_null($file)) {
                            $controllerName = str_replace('/', '\\', $root->getPath()) . '\\ControllerIndex';
                            break;
                        } else {
                            $root = $oldRoot;
                            $file = $root->getFile('Controller' . ucfirst($part) . '.php');
                            if (!is_null($file)) {
                                $controllerName = str_replace('/', '\\', $root->getPath()) . '\\Controller' . ucfirst($part);
                                break;
                            }
                        }
                    }
                    continue;
                }

                $file = $root->getFile('Controller' . ucfirst($part) . '.php');
                if (!is_null($file)) {
                    $controllerName = str_replace('/', '\\', $root->getPath()) . '\\Controller' . ucfirst($part);
                    break;
                }

                $file = $root->getFile('ControllerIndex.php');
                if (!is_null($file)) {
                    $pathParts[] = $previousPart;
                    $controllerName = str_replace('/', '\\', $root->getPath()) . '\\ControllerIndex';
                    break;
                }
            }
        }

        if (!class_exists($controllerName)) {
            throw new Exception("Controller \"{$controllerName}\" not found.");
        }

        $controller = new $controllerName();
        return $controller;
    }

    /**
     * Find action
     *
     * @param ControllerInterface $controller
     * @param string|null $pathPart
     * @return string
     * @throws Exception
     */
    public function findAction(ControllerInterface $controller, $pathPart = null)
    {
        $action = is_null($pathPart) ? 'actionIndex' : 'action' . ucfirst($pathPart);
        if (!method_exists($controller, $action)) {
            throw new Exception("Action \"{$action}\" of controller \"" . get_class($controller) . "\"");
        }

        return $action;
    }

    /**
     * Check root exists or sets
     *
     * @return bool
     */
    public function hasRoot()
    {
        return !is_null($this->root) || $this->root->exists();
    }

    /**
     * Check uri sets
     *
     * @return bool
     */
    public function hasURI()
    {
        return !is_null($this->uri);
    }

    /**
     * Set controllers root
     *
     * @param string $root
     * @return $this
     */
    public function setRoot($root)
    {
        if (!is_string($root)) {
            throw new InvalidArgumentException('Controllers root path must be a string.');
        }

        if (!file_exists($root)) {
            throw new InvalidArgumentException('Controllers root not exists.');
        }

        if (!is_dir($root)) {
            throw new InvalidArgumentException('Controllers root must be a directory path');
        }

        $this->root = new Directory($root);
        return $this;
    }

    /**
     * Set URI
     *
     * @param Uri $uri
     * @return $this
     */
    public function setURI(Uri $uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * Start route
     *
     * @return callable
     * @throws Exception
     */
    public function route()
    {
        $pathParts = array_diff(explode('/', $this->uri->getPath()), ['']);
        try {
            $controller = $this->findController($pathParts);
            $action = $this->findAction($controller, array_shift($pathParts));
        } catch (Exception $e) {
            $controllerName = str_replace('/', '\\', $this->root->getPath()) . '\\Controller404';
            if (!class_exists($controllerName)) {
                throw new Exception('Controller or action is not exists.');
            }

            $controller = new $controllerName();
            $action = 'actionIndex';

            if (!method_exists($controller, $action)) {
                throw new Exception('Controller or action is not exists.');
            }
        }

        return function(Request $request) use ($controller, $action) {
            $controller->beforeAction($request);
            $controller->{$action}($request);
            $controller->afterAction($request);
        };
    }

}