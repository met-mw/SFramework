<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 06.10.15
 */

namespace kernel\controllers;


use kernel\interfaces\Interface_Controller;
use kernel\views\View_Main;

class Controller_Main implements Interface_Controller {

    public function actionIndex() {
        $view = new View_Main();
        $view->message = 'Добро пожаловать в met-framework. Если Вы видите этот текст, значит всё хорошо.';
        $view->render();
    }

}