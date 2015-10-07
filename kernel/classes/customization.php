<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 07.10.15
 */

namespace kernel\classes;


use kernel\classes\customization\File;
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

    public function asFile() {
        return new File($this->value);
    }

    public function asFilesArray() {
        $files = [];
        for ($i = 0; $i < count($this->value['name']); $i++) {
            $files[] = new File([
                'name' => $this->value['name'][$i],
                'type' => $this->value['type'][$i],
                'tmp_name' => $this->value['tmp_name'][$i],
                'error' => $this->value['error'][$i],
                'size' => $this->value['size'][$i]
            ]);
        }

        return $files;
    }
}