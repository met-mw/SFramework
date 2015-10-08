<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 09.10.15
 */

namespace application\views;


use application\models\Model_Example;
use kernel\classes\View;

class View_Example extends View {

    public $header;
    public $message;
    public $example;
    /** @var Model_Example */
    public $firstExample;

    public function currentRender() {
        ?>
        <h1><?= $this->header ?></h1>
        <p><?= $this->message ?></p>
        <ul>
        <? foreach ($this->example as $row): ?>
            <li>ID: <?= $row['id'] ?>; TEXT: <?= $row['text'] ?></li>
        <? endforeach; ?>
        </ul>
        <h2><?= $this->firstExample->text ?></h2>
        <?
    }

}