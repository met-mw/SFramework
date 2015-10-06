<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 06.10.15
 */

namespace kernel\interfaces;


interface Interface_View {

    /**
     * Рендеринг представления. Обязательный метод для всех представлений.
     */
    public function render();

} 