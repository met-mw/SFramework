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

    public function noEmpty($errorText = null) {
        if ($this->original() == '') {
            NotificationLog::instance()->pushError(is_null($errorText) ? "Параметр \"{$this->name}\" не должен быть пуст." : $errorText);
        }

        return $this;
    }

    public function asInteger($required = true, $errorText = null) {
        if ($required && !is_numeric($this->original())) {
            NotificationLog::instance()->pushError(is_null($errorText) ? "Параметр \"{$this->name}\" не явялется числом." : $errorText);
        }

        return is_null($this->original()) ? $this->original() : (int)$this->original();
    }

    public function asString($required = true, $errorText = null) {
        if ($required && !is_string($this->original())) {
            NotificationLog::instance()->pushError(is_null($errorText) ? "Параметр \"{$this->name}\" не явялется строкой." : $errorText);
        }

        return is_null($this->original()) ? $this->original() : (string)$this->original();
    }

    public function asEmail($required = true, $errorText = null) {
        if ($required && !filter_var($this->original(), FILTER_VALIDATE_EMAIL)) {
            NotificationLog::instance()->pushError(is_null($errorText) ? "Параметр \"{$this->name}\" не является адресом email." : $errorText);
        }

        return is_null($this->original()) ? $this->original() : (string)$this->original();
    }

    public function asBool($required = true, $errorText = null) {
        if ($required && !is_bool($this->original())) {
            NotificationLog::instance()->pushError(is_null($errorText) ? "Параметр \"{$this->name}\" не является булевским типом." : $errorText);
        }

        return is_null($this->original()) ? $this->original() : (string)$this->original();
    }

    public function asArray($required = true, $errorText = null) {
        if ($required && !is_array($this->original())) {
            NotificationLog::instance()->pushError(is_null($errorText) ? "Параметр \"{$this->name}\" не является массивом." : $errorText);
        }

        return is_null($this->original()) ? $this->original() : (bool)$this->original();
    }

    public function asFile() {
        if (is_array($this->original())) {
            return new File($this->original());
        }

        NotificationLog::instance()->pushError("\"{$this->name}\" не является массивом информации о файле.");
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

        NotificationLog::instance()->pushError("\"{$this->name}\" не является массивом информации о файлах.");
        return false;
    }

    public function exists() {
        return !is_null($this->original());
    }

}