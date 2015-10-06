<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 06.10.15
 */

namespace kernel\controllers;


use kernel\interfaces\Interface_Controller;
use kernel\views\View_Error404;

class Controller_Error404 implements Interface_Controller {

    public function actionIndex() {
        $view = new View_Error404();
        $view->message = 'Страница не найдена: 404';
        $view->render();
    }

}