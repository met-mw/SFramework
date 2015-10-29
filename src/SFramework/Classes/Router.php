<?php
namespace SFramework\Classes;


use Exception;

/**
 * Class Router
 *
 * Роутер
 */
class Router {

    private $route;
    private $config = [];

    public function setConfig(array $config) {
        $this->config = $config;
    }

    /**
     * Осуществить роутинг
     */
    public function route() {
        list($route, $parametersString) = explode('?', $this->route);
        $parameters = $this->parseParameters($parametersString);

        $exploded = array_diff(explode('/', $route), ['']);
        if (count($exploded) == 0) {
            $controller = $this->config['controllersRoot'] . $this->config['defaultControllerPrefix'] . $this->config['defaultController'];
            $action = $this->config['defaultActionPrefix'] . $this->config['defaultAction'];
            if (!class_exists($controller) || !method_exists($controller, $action)) {
                $controller = $this->error404();
            }
        } else {
            $controller = $this->searchController($this->config['controllersRoot'], $exploded, $this->config['defaultControllerPrefix']);
            if (count($exploded) == 0 && method_exists($controller, $this->config['defaultActionPrefix'] . $this->config['defaultAction'])) {
                $action = $this->config['defaultActionPrefix'] . $this->config['defaultAction'];
            } elseif (method_exists($controller, $this->config['defaultActionPrefix'] . ucfirst(reset($exploded)))) {
                $action = $this->config['defaultActionPrefix'] . ucfirst(array_shift($exploded));
            } else {
                $action = $this->config['defaultActionPrefix'] . $this->config['defaultAction'];
                $controller = $this->error404();
            }
        }

        $controllerObject = new $controller($parameters);
        $controllerObject->$action();
    }

    /**
     * Найти контроллер
     *
     * @param string $controller
     * @param array $explodedRoute
     * @param string $controllerPrefix
     *
     * @return string
     */
    private function searchController($controller, array &$explodedRoute, $controllerPrefix) {
        $current = array_shift($explodedRoute);
        $currentClassLastName = ucfirst($current);
        $routesCount = count($explodedRoute);
        $probeClassName = "{$controller}{$controllerPrefix}{$currentClassLastName}";
        if ($routesCount <= 1 && class_exists($probeClassName)) {
            if (($routesCount == 1 && $this->checkControllerAction($probeClassName, $this->config['defaultActionPrefix'] . ucfirst(reset($explodedRoute)))) || $routesCount == 0) {
                return $probeClassName;
            } else {
                $controller = $this->searchController("{$controller}{$current}\\", $explodedRoute, "{$controllerPrefix}{$currentClassLastName}_");
            }
        } else {
            if (count($explodedRoute) == 0) {
                return $this->error404();
            } else {
                $controller = $this->searchController("{$controller}{$current}\\", $explodedRoute, "{$controllerPrefix}{$currentClassLastName}_");
            }
        }

        return $controller;
    }

    private function checkControllerAction($controllerName, $action) {
        return method_exists($controllerName, $action);
    }

    private function parseParameters($parametersString) {
        $parameters = [];
        if (!is_null($parametersString)) {
            foreach (explode('&', $parametersString) as $parameter) {
                list($name, $value) = explode('=', $parameter);
                if (strpos($name, '[]')) {
                    $parameters[str_replace('[]', '', $name)][] = $value;
                } else {
                    $parameters[$name] = $value;
                }
            }
        }

        return $parameters;
    }

    /**
     * Контроллер или действие контроллера не найдено
     */
    public function error404() {
        $className = $this->config['controllersRoot'] . $this->config['defaultControllerPrefix'] . '404';
        $action = $this->config['defaultActionPrefix'] . $this->config['defaultAction'];
        if (!class_exists($className) || !method_exists($className, $action)) {
            throw new Exception("Системе не удалось найти указанный адрес: \"{$this->route}\"");
        }

        return $className;
    }

    /**
     * Установить uri
     *
     * @param string $route uri
     */
    public function setRoute($route) {
        $this->route = $route;
    }

    /**
     * Получить uri
     *
     * @return string
     */
    public function getRoute() {
        return $this->route;
    }

} 