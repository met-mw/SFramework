<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 06.10.15
 */

namespace kernel\interfaces;


interface Interface_Controller {

    /**
     * Действие контроллера по умолчанию, должно обязательно присутствовать во всех контроллерах
     */
    public function actionIndex();

} 