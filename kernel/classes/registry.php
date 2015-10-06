<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 04.10.15
 */

namespace kernel\classes;


use kernel\orm\interfaces\Interface_Driver;

class Registry {

    static private $container = [];
    static private $lock = [];

    static public function get($name) {
        return self::$container[$name];
    }

    static public function set($name, $value, $lock = false) {
        if (!isset(self::$lock[$name])) {
            self::$container[$name] = $value;
            if ($lock) {
                self::$lock[] = $name;
            }
        }
    }

    /**
     * @return Interface_Driver
     */
    static public function db() {
        return isset(self::$container['db']) ? self::$container['db'] : null;
    }

    /**
     * @return Router
     */
    static public function router() {
        return isset(self::$container['router']) ? self::$container['router'] : null;
    }

} 