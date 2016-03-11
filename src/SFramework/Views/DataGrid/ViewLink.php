<?php
namespace SFramework\Views\DataGrid;


class ViewLink extends ViewDecoration {

    public function currentRender() {
        ?><a href="<?= $this->getValue() ?>"><?= $this->getValue() ?></a><?
    }

}