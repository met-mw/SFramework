<?php
namespace SFramework\Interfaces;


interface InterfaceView {

    /**
     * Рендеринг представления. Обязательный метод для всех представлений.
     */
    public function render();

    public function currentRender();

}