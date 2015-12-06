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
        if (!is_numeric($this->original())) {
            NotificationLog::instance()->pushError("Параметр \"{$this->name}\" не явялется числом.");
        }

        return is_null($this->original()) ? $this->original() : (int)$this->original();
    }

    public function asString() {
        if (!is_string($this->original())) {
            NotificationLog::instance()->pushError("Параметр \"{$this->name}\" не явялется строкой.");
        }

        return is_null($this->original()) ? $this->original() : (string)$this->original();
    }

    public function asEmail() {
        if (!filter_var($this->original(), FILTER_VALIDATE_EMAIL)) {
            NotificationLog::instance()->pushError("Параметр \"{$this->name}\" не является адресом email.");
        }

        return is_null($this->original()) ? $this->original() : (string)$this->original();
    }

    public function asBool() {
        if (!is_bool($this->original())) {
            NotificationLog::instance()->pushError("Параметр \"{$this->name}\" не является булевским типом.");
        }


    }

    public function asArray() {
        if (!is_array($this->original())) {
            NotificationLog::instance()->pushError("Параметр \"{$this->name}\" не является массивом.");
        }

        return is_null($this->original()) ? $this->original() : (bool)$this->original();
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