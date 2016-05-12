<?php
namespace SFramework\Views;


use SFramework\Classes\View;

class ViewText extends View
{

    /** @var string */
    public $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function currentRender()
    {
        echo $this->text;
    }

}