<?php


namespace SFramework\Views\DataGrid;


class ViewDateTime extends ViewDecoration
{

    /** @var string */
    public $format;

    public function __construct($format)
    {
        $this->format = $format;
    }

    public function currentRender()
    {
        echo date($this->format, strtotime($this->getValue()));
    }

}