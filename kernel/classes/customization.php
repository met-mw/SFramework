<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 07.10.15
 */

namespace kernel\classes;


use kernel\interfaces\Interface_Customization;

class Customization implements Interface_Customization {

    private $value = null;

    public function __construct($value) {
        $this->value = $value;
    }

    public function asInteger() {
        return (int)$this->value;
    }

    public function asString() {
        return (string)$this->value;
    }

    public function asEmail() {
        // TODO: Implement asEmail() method.
    }

    public function asBool() {
        return (bool)$this->value;
    }

    public function asArray() {
        return (array)$this->value;
    }
}