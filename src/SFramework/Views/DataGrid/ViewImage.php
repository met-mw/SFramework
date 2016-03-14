<?php
namespace SFramework\Views\DataGrid;


use SFramework\Classes\CoreFunctions;

class ViewImage extends ViewDecoration {

    public $attributes;

    public function __construct(array $attributes = []) {
        $this->attributes = $attributes;
    }

    public function currentRender() {
        ?><img src="<?= $this->getValue() ?>"<?= empty($this->attributes) ? '' : CoreFunctions::tagAttributesToString($this->attributes) ?>/><?
    }

}