<?php
namespace App\Views;


use SFramework\ViewAbstract;

class ViewIndex extends ViewAbstract
{

    public $anyText;

    /**
     * @return void
     */
    protected function currentRender()
    {
        ?>
            <h1>This is a example view.</h1>
            <p><?= $this->anyText ?></p>
        <?
    }

}