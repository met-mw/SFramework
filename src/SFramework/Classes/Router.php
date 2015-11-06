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
        $route = trim($route, '/');
        $parameters = $this->parseParameters($parametersString);

        $exploded = array_diff(explode('/', $route), ['']);
        $controller = $this->searchController($this->config['controllersRoot'], $exploded);
        $action = empty($exploded) ? 'actionIndex' : 'action' . ucfirst(array_shift($exploded));

        $controllerObject = new $controller($parameters);
        $controllerObject->$action();
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