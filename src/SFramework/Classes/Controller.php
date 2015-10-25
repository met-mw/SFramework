<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 07.10.15
 */

namespace SFramework\Classes;


use SFramework\Interfaces\InterfaceController;

abstract class Controller implements InterfaceController {

    /** @var Customization[] */
    private $params = [];

    public function __construct(array $params = []) {
        $this->params = $params;
    }

    public function param($name) {
        return new Customization($this->params[$name]);
    }

}