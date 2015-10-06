<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 06.10.15
 */

namespace kernel\classes;

/**
 * Class Router
 * @package kernel\classes
 *
 * Роутер. Находит контроллер и вызывает его определённый метод,
 * определённый по uri
 */
class Router {

    private $route;

    /**
     * Осуществить роутинг
     */
    public function route() {
        list($route, $parametersString) = explode('?', $this->route);
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

        if ($route == '/') {
            $userController = 'application\\controllers\\Controller_Main';
            $systemController = 'kernel\\controllers\\Controller_Main';
            if (class_exists($userController)) {
                call_user_func([$userController, 'actionIndex']);
            } elseif (class_exists($systemController)) {
                call_user_func([$systemController, 'actionIndex']);
            } else {
                $this->error404();
            }
            return;
        }

        $exploded = explode('/', $route);
        array_shift($exploded);
        $controller = 'application\\controllers\\Controller_' . ucfirst(array_shift($exploded));
        if (class_exists($controller)) {
            if (count($exploded) == 0 || reset($exploded) == '') {
                $action = 'actionIndex';
            } elseif (method_exists($controller, 'action' . ucfirst(reset($exploded)))) {
                $action = 'action' . ucfirst(array_shift($exploded));
            } else {
                $this->error404();
                return;
            }

            if (method_exists($controller, $action)) {
                $controllerObject = new $controller($parameters);
                $controllerObject->$action();
            } else {
                $this->error404();
            }
        } else {

            $this->error404();
        }
    }

    /**
     * Контроллер или действие контроллера не найдено
     */
    public function error404() {
        $userController = 'application\\controllers\\Controller_Error404';
        $systemController = 'kernel\\controllers\\Controller_Error404';
        if (class_exists($userController)) {
            call_user_func([$userController, 'actionIndex']);
        } else {
            call_user_func([$systemController, 'actionIndex']);
        }
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