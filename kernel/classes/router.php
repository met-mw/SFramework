<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 06.10.15
 */

namespace kernel\classes;


class Router {

    private $route;

    public function route() {
        if ($this->route == '/') {
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

        $exploded = explode('/', $this->route);
        array_shift($exploded);
        $controller = 'application\\controllers\\Controller_' . ucfirst(array_shift($exploded));
        if (class_exists($controller)) {
            $action = 'actionIndex';
            if (method_exists($controller, 'action' . ucfirst(reset($exploded)))) {
                $action = 'action' . ucfirst(array_shift($exploded));
            }

            if (method_exists($controller, $action)) {
                call_user_func_array([$controller, $action], $exploded);
            } else {
                $this->error404();
            }
        } else {
            $this->error404();
        }
    }

    public function error404() {
        $userController = 'application\\controllers\\Controller_Error404';
        $systemController = 'kernel\\controllers\\Controller_Error404';
        if (class_exists($userController)) {
            call_user_func([$userController, 'actionIndex']);
        } else {
            call_user_func([$systemController, 'actionIndex']);
        }
    }

    public function setRoute($route) {
        $this->route = $route;
    }

    public function getRoute() {
        return $this->route;
    }

} 