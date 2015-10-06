<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 04.10.15
 */

namespace kernel\orm;


use kernel\orm\interfaces\Interface_Driver;
use kernel\orm\traits\Trait_Setting;

/**
 * Class Driver
 * @package kernel\orm
 *
 * Базовый класс драйвера доступа к данным
 */
class Driver implements Interface_Driver {

    use Trait_Setting;

    public function query($query) {
        // TODO: Implement query() method.
    }

    public function fetchAssoc() {
        // TODO: Implement fetchAssoc() method.
    }

    public function fetchRow() {
        // TODO: Implement fetchRow() method.
    }

    public function fetchFields() {
        // TODO: Implement fetchFields() method.
    }

    public function lastInsertId() {
        // TODO: Implement lastInsertId() method.
    }

    public function prepare($query) {
        // TODO: Implement prepare() method.
    }

    public function bindParameter($types, array $attributes) {
        // TODO: Implement bindParameter() method.
    }

    public function execute() {
        // TODO: Implement execute() method.
    }
}