<?php
namespace SFramework\Classes;


use Exception;

/**
 * Class Router
 *
 * Роутер
 */
class Router {

    public $currentControllerName = null;
    public $currentActionName = null;

    private $route;
    private $config = [];

    public function setConfig(array $config) {
        $this->config = $config;
    }

    public function explodeRoute() {
        $route = trim(explode('?', $this->route)[0], '/');
        return array_diff(explode('/', $route), ['']);
    }

    public function getParameters() {
        $parametersString = explode('?', $this->route)[1];
        return $this->parseParameters($parametersString);
    }

    public function splitRoute() {
        $routeParts = explode('?', $this->route);
        $route = isset($routeParts[0]) ? $routeParts[0] : '';
        $parametersString = isset($routeParts[1]) ? $routeParts[1] : null;

        return [$route, $parametersString];
    }

    /**
     * Осуществить роутинг
     */
    public function route() {
        list($route, $parametersString) = $this->splitRoute();
        $route = trim($route, '/');
//        $parameters = $this->parseParameters($parametersString);

        $exploded = array_diff(explode('/', $route), ['']);
        $this->currentControllerName = $this->searchController($this->config['controllersRoot'], $exploded);
        $this->currentActionName = empty($exploded) ? 'actionIndex' : 'action' . ucfirst(array_shift($exploded));

        $controllerObject = new $this->currentControllerName(/* $parameters */); // TODO: Открыть после реализации фильров
        $controllerObject->{$this->currentActionName}();
    }

    /**
     * Найти контроллер
     *
     * @param string $controller
     * @param array $explodedRoute
     *
     * @return string
     */
    private function searchController($controller, array &$explodedRoute) {
        $current = array_shift($explodedRoute);
        $currentClassLastName = is_null($current) ? 'Main' : ucfirst($current);
        $routesCount = count($explodedRoute);
        $probeClassName = "{$controller}Controller{$currentClassLastName}";
        if ($routesCount <= 1 && class_exists($probeClassName)) {
            if (($routesCount == 1 && $this->checkControllerAction($probeClassName, 'action' . ucfirst(reset($explodedRoute)))) || $routesCount == 0) {
                return $probeClassName;
            }
            $controller = $this->searchController("{$controller}{$currentClassLastName}\\", $explodedRoute, $currentClassLastName);
        } else {
            if (is_null($current) && $routesCount == 0) {
                return $this->error404();
            }
            $controller = $this->searchController("{$controller}{$currentClassLastName}\\", $explodedRoute, $currentClassLastName);
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
        $className = "{$this->config['controllersRoot']}Controller404";
        $action = "actionIndex";
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