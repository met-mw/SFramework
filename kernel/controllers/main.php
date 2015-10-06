<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 06.10.15
 */

namespace kernel\controllers;


use kernel\classes\Controller;
use kernel\views\View_Main;

/**
 * Class Controller_Main
 * @package kernel\controllers
 *
 * Контроллер по умолчанию для главной страницы
 */
class Controller_Main extends Controller {

    public function actionIndex() {
        $view = new View_Main();
        $view->message = 'Добро пожаловать в met-framework. Если Вы видите этот текст, значит всё хорошо.';
        $view->render();
    }

}