<?php
namespace SFramework\Classes;


/**
 * Class Controller
 * @package SFramework\Classes
 *
 * Базовый класс контроллера
 */
abstract class Controller {

    /** @var Frame */
    protected $frame = null;

    public function getFrame()
    {
        return $this->frame;
    }

    public function setFrame(Frame $frame)
    {
        $this->frame = $frame;
    }

}