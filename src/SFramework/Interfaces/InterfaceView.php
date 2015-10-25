<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 06.10.15
 */

namespace SFramework\Interfaces;


interface InterfaceView {

    /**
     * Рендеринг представления. Обязательный метод для всех представлений.
     */
    public function render();

}