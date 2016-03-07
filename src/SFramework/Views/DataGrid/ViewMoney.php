<?php


namespace SFramework\Views\DataGrid;


class ViewMoney extends ViewDecoration {

    public $currencySymbol;

    public function __construct($currencySymbol) {
        $this->currencySymbol = $currencySymbol;
    }

    public function currentRender() {
        $isEmpty = is_null($this->getValue()) || $this->getValue() === '';
        ?>
        <span class="label label-<?= $isEmpty ? 'default' : 'success' ?>">
            <?= $isEmpty ? '--.--' : $this->getValue() ?>
        </span>
        <?= $this->currencySymbol ?>
    <?
    }

}