<?php
namespace SFramework\Views\DataGrid;


class ViewLink extends ViewDecoration {

    public function currentRender() {
        ?><a target="_blank" href="<?= $this->getValue() ?>"><?= $this->getValue() ?></a><?
    }

}