<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 06.10.15
 */

namespace kernel\views;


use kernel\classes\View;

/**
 * Class View_Main
 * @package kernel\views
 *
 * Представление по умолчанию для главной страницы
 */
class View_Main extends View {

    public $message;

    public function currentRender() {
        ?>
        <html>
            <head>
                <title>Главная страница</title>
            </head>
            <body>
                <h1>Главная страница</h1>
                <p><?= $this->message ?></p>
            </body>
        </html>
        <?
    }
}