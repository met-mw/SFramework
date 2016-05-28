<?php
namespace SFramework\Classes\DataGrid;


use SFramework\Classes\DataGrid\Menu\Element;

class Menu
{

    /** @var string */
    protected $name;
    /** @var Element[] */
    protected $Elements = [];

    public function __construct($name = '')
    {
        $this->setName($name);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function addElement(Element $Element)
    {
        $this->Elements[] = $Element;
        return $this;
    }

    public function getElements()
    {
        return $this->Elements;
    }

}