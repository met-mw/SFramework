<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 21.10.15
 */

namespace kernel\orm\classes;


use kernel\orm\interfaces\Interface_Driver;

class Orm_Registry {

    static private $container = [];

    /**
     * Получить данные из реестра
     *
     * @param string $name Имя записи
     *
     * @return Interface_Driver
     */
    static public function get($name) {
        return self::$container[$name];
    }

    /**
     * Добавить данные в реестр
     *
     * @param Interface_Driver $driver Драйвер
     */
    static public function add(Interface_Driver $driver) {
        if (!isset(self::$container[$driver::cls()])) {
            self::$container[$driver::cls()] = $driver;
        }
    }

    private function __construct() {}

} 