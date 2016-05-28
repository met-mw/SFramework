<?php
namespace SFramework\Views;


use SFramework\Classes\View;

class ViewErrors extends View
{

    /** @var string[] */
    public $messages;

    public function currentRender() {
        ?>
        <h3>При работе системы возникли ошибки. Пожалуйста, сообщие от этом администратору.</h3>
        <ol>
            <? foreach ($this->messages as $message): ?>
                <li>
                    <?= $message ?>
                </li>
            <? endforeach; ?>
        </ol>
        <?
    }

}