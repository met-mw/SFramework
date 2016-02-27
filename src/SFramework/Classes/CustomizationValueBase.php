<?php
namespace SFramework\Classes;


abstract class CustomizationValueBase {

    protected $value = null;

    public function __construct($value = null) {
        $this->setValue($value);
    }

    abstract public function isExists();

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

} 