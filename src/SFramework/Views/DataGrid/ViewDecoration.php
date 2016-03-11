<?php
namespace SFramework\Views\DataGrid;


use SFramework\Classes\View;

abstract class ViewDecoration extends View {

    /** @var string|null */
    protected $value = null;
    /** @var array */
    protected $additionalData = [];

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function setAdditionalData(array $additionalData = []) {
        $this->additionalData = $additionalData;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

    public function getAdditionalData() {
        return $this->additionalData;
    }

} 