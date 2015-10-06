<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 07.10.15
 */

namespace kernel\classes;


use kernel\interfaces\Interface_Controller;

abstract class Controller implements Interface_Controller {

    /**
     * @var Customization[]
     */
    private $params = [];

    public function __construct(array $params = []) {
        foreach ($params as $name => $value) {
            $this->params[$name] = new Customization($value);
        }
    }

    public function param($name) {
        return $this->params[$name];
    }

}