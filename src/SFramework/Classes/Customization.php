<?php
namespace SFramework\Classes;


use SFramework\Classes\Customization\File;
use SFramework\Interfaces\InterfaceCustomization;

/**
 * Class Customization
 * @package SFramework\Classes
 *
 * Приводит значение к определённому типу, совместно является базовой валидацией
 */
class Customization implements InterfaceCustomization {

    private $name;
    private $value = null;

    public function __construct($name, $value) {
        $this->name = $name;
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

        NotificationLog::instance()->pushError("Параметр \"{$this->name}\" не является адресом email.");
        return false;
    }

    public function asBool() {
        return is_null($this->original()) ? $this->original() : (bool)$this->original();
    }

    public function asArray() {
        if (is_array($this->original())) {
            return (array)$this->original();
        }

        NotificationLog::instance()->pushError("Параметр \"{$this->name}\" не является массивом.");
        return false;
    }

    public function asFile() {
        if (is_array($this->original())) {
            return new File($this->original());
        }

        NotificationLog::instance()->pushError("Параметр \"{$this->name}\" не является массивом информации о файле.");
        return false;
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

        NotificationLog::instance()->pushError("Параметр \"{$this->name}\" не является массивом информации о файлах.");
        return false;
    }

    public function exists() {
        return !is_null($this->original());
    }

}