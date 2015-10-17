<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 06.10.15
 */

namespace application\controllers;


use application\views\View_Example;
use kernel\classes\Controller;
use kernel\classes\Registry;

class Controller_Example extends Controller {

    public function actionIndex() {
        $frame = Registry::frame('example');

        $frame->setTitle('Пример'); // Устанавливаем заголовок страницы

        // Подготавливаем представление
        $view = new View_Example();
        $view->header = 'Страница-пример';
        $view->message = 'Это страница-пример. Если видишь её, значит всё работает как надо. Теперь добавь свои контроллеры и представления в папку application. Также можешь переделать этот контроллер. Развлекайся!';

        // Назначаем представление фрейму на метку 'content'
        $frame->bindView('content', $view);

        $frame->render(); // Отрисовываем страницу
    }

}