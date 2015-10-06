<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 06.10.15
 */

namespace kernel\views;


use kernel\interfaces\Interface_View;

class View_Main implements Interface_View {

    public $message;

    public function render() {
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