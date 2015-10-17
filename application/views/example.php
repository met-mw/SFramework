<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 09.10.15
 */

namespace application\views;


use kernel\classes\View;

class View_Example extends View {

    public $header;
    public $message;

    public function currentRender() {
        ?>
        <h1><?= $this->header ?></h1>
        <p><?= $this->message ?></p>
        <?
    }

}