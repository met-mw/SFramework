<?php
namespace App\Views;


use SFramework\ViewAbstract;

class View404 extends ViewAbstract
{

    /**
     * @return void
     */
    protected function currentRender()
    {
        ?><h1>Страница не найдена.</h1><?
    }

}