<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 06.10.15
 */

namespace kernel\controllers;


use kernel\classes\Controller;
use kernel\views\View_Error404;

/**
 * Class Controller_Error404
 * @package kernel\controllers
 *
 * Контроллер по умолчанию для не найденной страницы
 */
class Controller_Error404 extends Controller {

    public function actionIndex() {
        $view = new View_Error404();
        $view->message = 'Страница не найдена: 404';
        $view->render();
    }

}