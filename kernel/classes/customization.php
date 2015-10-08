<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 07.10.15
 */

namespace kernel\classes;


use Exception;
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
        if (filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            return $this->value;
        }

        throw new Exception("Параметр не является адресом email");
    }

    public function asBool() {
        return (bool)$this->value;
    }

    public function asArray() {
        if (is_array($this->value)) {
            return (array)$this->value;
        }

        throw new Exception("Параметр не является массивом");
    }

    public function asFile() {
        if (is_array($this->value)) {
            return new File($this->value);
        }

        throw new Exception("Параметр не является массивом информации о файле");
    }

    public function asFilesArray() {
        if (is_array($this->value)) {
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

        throw new Exception("Параметр не является массивом информации о файле");
    }
}