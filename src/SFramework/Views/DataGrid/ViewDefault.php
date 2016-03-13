<?php
namespace SFramework\Views\DataGrid;


class ViewDefault extends ViewDecoration {

    public function currentRender() {
        echo $this->getValue();
    }

}