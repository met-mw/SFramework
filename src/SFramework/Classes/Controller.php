<?php
namespace SFramework\Classes;


use SFramework\Interfaces\InterfaceController;

/**
 * Class Controller
 * @package SFramework\Classes
 *
 * Базовый класс контроллера
 */
abstract class Controller implements InterfaceController {

    /** @var Customization[] */
    private $params = [];

    public function __construct(array $params = []) {
        $this->params = $params;
    }

    /**
     * Получить параметр
     *
     * @param string $name Имя параметра
     *
     * @return Customization
     */
    public function param($name) {
        return new Customization($this->params[$name]);
    }

}