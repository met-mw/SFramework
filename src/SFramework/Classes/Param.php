<?php
namespace SFramework\Classes;


use SFramework\Interfaces\InterfaceParam;

/**
 * Class Param
 *
 * Обработчик параметров, переданных серверу
 */
class Param implements InterfaceParam {

    static public function get($name, $required = true) {
        if ($required && !isset($_GET[$name])) {
            NotificationLog::instance()->pushError("Не задан обязательный параметр \"{$name}\".");
        }

        $value = isset($_GET[$name])
            ? new CustomizationValue($_GET[$name])
            : new CustomizationValueNull();
        return new Customization($name, $value);
    }

    static public function post($name, $required = true) {
        if ($required && !isset($_POST[$name])) {
            NotificationLog::instance()->pushError("Не задан обязательный параметр \"{$name}\".");
        }

        $value = isset($_GET[$name])
            ? new CustomizationValue($_GET[$name])
            : new CustomizationValueNull();
        return new Customization($name, $value);
    }

    static public function request($name, $required = true) {
        if ($required && !isset($_REQUEST[$name])) {
            NotificationLog::instance()->pushError("Не задан обязательный параметр \"{$name}\".");
        }

        $value = isset($_GET[$name])
            ? new CustomizationValue($_GET[$name])
            : new CustomizationValueNull();
        return new Customization($name, $value);
    }

    static public function file($name, $required = true) {
        if ($required && !isset($_FILES[$name])) {
            NotificationLog::instance()->pushError("Не задан обязательный параметр \"{$name}\".");
        }

        $value = isset($_GET[$name])
            ? new CustomizationValue($_GET[$name])
            : new CustomizationValueNull();
        return new Customization($name, $value);
    }

}