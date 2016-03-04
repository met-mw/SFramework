<?php
namespace SFramework\Views\DataGrid;


use SFramework\Classes\View;

abstract class ViewDecoration extends View {

    protected $value = null;

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

} 