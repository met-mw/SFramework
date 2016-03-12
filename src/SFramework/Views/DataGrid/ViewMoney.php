<?php


namespace SFramework\Views\DataGrid;


class ViewMoney extends ViewDecoration {

    public $currencySymbol;

    public function __construct($currencySymbol) {
        $this->currencySymbol = $currencySymbol;
    }

    public function currentRender() {
        $isEmpty = is_null($this->getValue()) || $this->getValue() === '';
        echo ($isEmpty ? '--.--' : $this->getValue()), $this->currencySymbol;
    }

}