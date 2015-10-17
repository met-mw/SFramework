<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 04.10.15
 */

namespace kernel\classes;


use kernel\orm\interfaces\Interface_Driver;

/**
 * Class Registry
 * @package kernel\classes
 *
 * Реестр. Заменитель глобальных переменных. Сюда помещаются данные,
 * которые могут понадобиться в любой части проекта.
 */
class Registry {

    static private $container = [];
    static private $lock = [];

    /**
     * Получить данные из реестра
     *
     * @param string $name Имя записи
     *
     * @return mixed
     */
    static public function get($name) {
        return self::$container[$name];
    }

    /**
     * Добавить данные в реестр
     *
     * @param string $name Имя записи
     * @param mixed $value Данные
     * @param bool $lock Заблокировать от перезаписи
     */
    static public function set($name, $value, $lock = false) {
        if (!isset(self::$lock[$name])) {
            self::$container[$name] = $value;
            if ($lock) {
                self::$lock[] = $name;
            }
        }
    }

    /**
     * Получить драйвер доступа к данным
     *
     * @return Interface_Driver
     */
    static public function dataSourceDriver() {
        return isset(self::$container['dataSourceDriver']) ? self::$container['dataSourceDriver'] : null;
    }

    /**
     * Получить роутер
     *
     * @return Router
     */
    static public function router() {
        return isset(self::$container['router']) ? self::$container['router'] : null;
    }

    /**
     * Получить фрейм
     *
     * @param $frameName
     *
     * @return Frame
     */
    static public function frame($frameName) {
        return isset(self::$container[$frameName]) ? self::$container[$frameName] : null;
    }

} 