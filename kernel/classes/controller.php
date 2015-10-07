<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 07.10.15
 */

namespace kernel\classes;


use kernel\interfaces\Interface_Controller;

abstract class Controller implements Interface_Controller {

    /** @var Customization[] */
    private $params = [];
    /** @var Frame */
    private $frame = null;

    public function __construct(array $params = []) {
        $this->params = $params;
        $this->frame = Registry::frame();
    }

    public function param($name) {
        return new Customization($this->params[$name]);
    }

    public function frame() {
        return $this->frame;
    }

}