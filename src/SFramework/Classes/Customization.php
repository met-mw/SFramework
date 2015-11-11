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
        return is_null($this->original()) ? $this->original() : (int)$this->original();
    }

    public function asString() {
        return is_null($this->original()) ? $this->original() : (string)$this->original();
    }

    public function asEmail() {
        if (filter_var($this->original(), FILTER_VALIDATE_EMAIL)) {
            return $this->original();
        }

        throw new Exception("Параметр не является адресом email");
    }

    public function asBool() {
        return is_null($this->original()) ? $this->original() : (bool)$this->original();
    }

    public function asArray() {
        if (is_array($this->original())) {
            return (array)$this->original();
        }

        throw new Exception("Параметр не является массивом");
    }

    public function asFile() {
        if (is_array($this->original())) {
            return new File($this->original());
        }

        throw new Exception("Параметр не является массивом информации о файле");
    }

    public function asFilesArray() {
        if (is_array($this->original())) {
            $original = $this->original();
            $files = [];
            for ($i = 0; $i < count($original['name']); $i++) {
                $files[] = new File([
                    'name' => $original['name'][$i],
                    'type' => $original['type'][$i],
                    'tmp_name' => $original['tmp_name'][$i],
                    'error' => $original['error'][$i],
                    'size' => $original['size'][$i]
                ]);
            }

            return $files;
        }

        throw new Exception("Параметр не является массивом информации о файле");
    }

    public function exists() {
        return !is_null($this->original());
    }

}