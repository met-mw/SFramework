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

    /** @var Frame */
    protected $frame;

}