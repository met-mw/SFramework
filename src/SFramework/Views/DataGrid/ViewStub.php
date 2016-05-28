<?php
namespace SFramework\Views\DataGrid;


class ViewStub extends ViewDecoration
{

    /** @var string */
    public $stub;

    public function __construct($stub)
    {
        $this->stub = $stub;
    }

    public function currentRender()
    {
        echo $this->stub;
    }

}