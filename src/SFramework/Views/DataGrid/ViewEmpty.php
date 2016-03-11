<?php


namespace SFramework\Views\DataGrid;


class ViewEmpty extends ViewDecoration {

    public $isEmptyText;
    public $isNotEmptyText;

    public function __construct($isEmptyText = ' - ', $isNotEmptyText = ' + ') {
        $this->isEmptyText = $isEmptyText;
        $this->isNotEmptyText = $isNotEmptyText;
    }

    public function currentRender() {
        $isEmpty = is_null($this->getValue()) || $this->getValue() === '';
        ?>
        <span class="label label-<?= $isEmpty ? 'default' : 'success' ?>">
            <?= $isEmpty ? $this->isEmptyText : $this->isNotEmptyText ?>
        </span>
        <?
    }

}