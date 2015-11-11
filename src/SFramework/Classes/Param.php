<?php
namespace SFramework\Classes;


use Exception;
use SFramework\Interfaces\InterfaceParam;

/**
 * Class Param
 *
 * Обработчик параметров, переданных серверу
 */
class Param implements InterfaceParam {

    static public function get($name, $required = true) {
        if ($required && !isset($_GET[$name])) {
            throw new Exception("Не задан обязательный параметр \"{$name}\".");
        }

        return new Customization(isset($_GET[$name]) ? $_GET[$name] : null);
    }

    static public function post($name, $required = true) {
        if ($required && !isset($_POST[$name])) {
            throw new Exception("Не задан обязательный параметр \"{$name}\".");
        }

        return new Customization(isset($_POST[$name]) ? $_POST[$name] : null);
    }

    static public function request($name, $required = true) {
        if ($required && !isset($_REQUEST[$name])) {
            throw new Exception("Не задан обязательный параметр \"{$name}\".");
        }

        return new Customization(isset($_REQUEST[$name]) ? $_REQUEST[$name] : null);
    }

    static public function file($name, $required = true) {
        if ($required && !isset($_FILES[$name])) {
            throw new Exception("Не задан обязательный параметр \"{$name}\".");
        }

        return new Customization(isset($_FILES[$name]) ? $_FILES[$name] : null);
    }

}