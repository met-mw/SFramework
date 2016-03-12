<?php
namespace SFramework\Views\DataGrid;


class ViewEmail extends ViewDecoration {

    public function currentRender() {
        ?><a href="mailto:<?= $this->getValue() ?>"><?= $this->getValue() ?></a><?
    }

}