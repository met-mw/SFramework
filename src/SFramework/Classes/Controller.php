<?php
namespace SFramework\Classes;


/**
 * Class Controller
 * @package SFramework\Classes
 *
 * Базовый класс контроллера
 */
abstract class Controller
{

    /** @var Frame */
    protected $Frame = null;

    public function getFrame()
    {
        return $this->Frame;
    }

    public function setFrame(Frame $Frame)
    {
        $this->Frame = $Frame;
    }

}