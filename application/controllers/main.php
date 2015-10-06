<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 06.10.15
 */

namespace application\controllers;


use kernel\classes\Controller;
use kernel\views\View_Main;

class Controller_Main extends Controller {

    public function actionIndex() {
        $view = new View_Main();
        $view->message = 'Это главная страница сайта по умолчанию. Если видишь её, значит всё работает как надо. Теперь добавь свои контроллеры и представления в папку application. Также можешь переделать этот контроллер. Развлекайся!';
        $view->render();
    }

}