<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 07.10.15
 */

namespace kernel\classes;


use kernel\interfaces\Interface_Param;

/**
 * Class Param
 * @package kernel\classes
 */
class Param implements Interface_Param {

    static public function get($name) {
        return new Customization(isset($_GET[$name]) ? $_GET[$name] : null);
    }

    static public function post($name) {
        return new Customization(isset($_POST[$name]) ? $_POST[$name] : null);
    }

    static public function request($name) {
        return new Customization(isset($_REQUEST[$name]) ? $_REQUEST[$name] : null);
    }

    static public function file($name) {
        return new Customization(isset($_FILES[$name]) ? $_FILES[$name] : null);
    }
}