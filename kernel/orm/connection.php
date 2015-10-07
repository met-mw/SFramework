<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 04.10.15
 */

namespace kernel\orm;


use kernel\orm\interfaces\Interface_Driver;

/**
 * Class Connection
 * @package kernel\orm
 *
 * Соединение. Посредник между проектом и драйвером для доступа к данным
 */
class Connection {

    static protected $instance = null;

    /** @var Interface_Driver */
    private $driver = null;

    protected  function __construct() {}

    static public function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $driver
     * @param array $settings
     */
    public function connect($driver, array $settings = []) {
        $this->driver = new $driver($settings);
    }

    public function getDriver() {
        return $this->driver;
    }

} 