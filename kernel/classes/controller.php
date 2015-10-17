<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 07.10.15
 */

namespace kernel\classes;


use kernel\interfaces\Interface_Controller;
use kernel\orm\interfaces\Interface_Driver;

abstract class Controller implements Interface_Controller {

    /** @var Customization[] */
    private $params = [];
    /** @var Interface_Driver */
    protected $driver = null;

    public function __construct(array $params = []) {
        $this->params = $params;
        $this->driver = Registry::dataSourceDriver();
    }

    public function param($name) {
        return new Customization($this->params[$name]);
    }

    public function driver() {
        return $this->driver;
    }

}