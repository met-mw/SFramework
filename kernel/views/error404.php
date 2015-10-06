<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 06.10.15
 */

namespace kernel\views;


use kernel\interfaces\Interface_View;

class View_Error404 implements Interface_View {

    public $message;

    public function render() {
        ?>
        <html>
            <head>
                <title>404</title>
            </head>
            <body>
                <h1><?= $this->message ?></h1>
            </body>
        </html>
        <?
    }
}