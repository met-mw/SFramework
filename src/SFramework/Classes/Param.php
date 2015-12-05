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

        return new Customization($name, isset($_GET[$name]) ? $_GET[$name] : null);
    }

    static public function post($name, $required = true) {
        if ($required && !isset($_POST[$name])) {
            NotificationLog::instance()->pushError("Не задан обязательный параметр \"{$name}\".");
        }

        return new Customization($name, isset($_POST[$name]) ? $_POST[$name] : null);
    }

    static public function request($name, $required = true) {
        if ($required && !isset($_REQUEST[$name])) {
            NotificationLog::instance()->pushError("Не задан обязательный параметр \"{$name}\".");
        }

        return new Customization($name, isset($_REQUEST[$name]) ? $_REQUEST[$name] : null);
    }

    static public function file($name, $required = true) {
        if ($required && !isset($_FILES[$name])) {
            NotificationLog::instance()->pushError("Не задан обязательный параметр \"{$name}\".");
        }

        return new Customization($name, isset($_FILES[$name]) ? $_FILES[$name] : null);
    }

}