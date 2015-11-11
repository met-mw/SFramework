<?php
namespace SFramework\Classes;


use Exception;
use SFramework\Classes\Customization\File;
use SFramework\Interfaces\InterfaceCustomization;

/**
 * Class Customization
 * @package SFramework\Classes
 *
 * Приводит значение к определённому типу, совместно является базовой валидацией
 */
class Customization implements InterfaceCustomization {

    private $value = null;

    public function __construct($value) {
        $this->value = $value;
    }

    public function original() {
        return $this->value;
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

    public function exists() {
        return !is_null($this->value);
    }

}