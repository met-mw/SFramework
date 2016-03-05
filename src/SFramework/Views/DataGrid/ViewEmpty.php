<?php


namespace SFramework\Views\DataGrid;


class ViewEmpty extends ViewDecoration {

    public function currentRender() {
        $isEmpty = is_null($this->getValue()) || $this->getValue() === '';
        ?>
        <span class="label label-<?= $isEmpty ? 'default' : 'success' ?>">
            <?= $isEmpty ? '-' : $this->getValue() ?>
        </span>
        <?
    }

}