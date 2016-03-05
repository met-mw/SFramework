<?php


namespace SFramework\Views\DataGrid\Menu;


use SFramework\Classes\View;

class ViewSeparator extends View {

    public function currentRender() {
        ?> | <?
    }

}