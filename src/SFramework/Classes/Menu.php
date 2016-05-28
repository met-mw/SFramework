<?php
namespace SFramework\Classes;


use SFramework\Classes\Menu\Item;

class Menu
{

    /** @var Item[] */
    private $LeftItems = [];
    /** @var Item[] */
    private $RightItems = [];

    /** @var string */
    private $projectName;
    /** @var string */
    private $startingPath;

    public function __construct($projectName, $startingPath = '')
    {
        $this->projectName = $projectName;
        $this->startingPath = $startingPath;
    }

    public function addLeftItem($name, $path, $tooltip = '')
    {
        $this->LeftItems[] = new Item($name, $path, $tooltip);
        return $this;
    }

    public function addRightItem($name, $path, $tooltip = '')
    {
        $this->RightItems[] = new Item($name, $path, $tooltip);
        return $this;
    }

    public function getProjectName()
    {
        return $this->projectName;
    }

    public function getStartingPath()
    {
        return $this->startingPath;
    }

    public function getLeftItems()
    {
        return $this->LeftItems;
    }

    public function getRightItems()
    {
        return $this->RightItems;
    }

    public function getLeftItem($index)
    {
        return $this->LeftItems[$index];
    }

    public function getRightItem($index)
    {
        return $this->RightItems[$index];
    }

    public function findLeftItemByPath($path)
    {
        $Item = null;
        $LeftItems = $this->getLeftItems();
        foreach ($LeftItems as $LeftItem) {
            if ($LeftItem->getPath() == $path) {
                $Item = $LeftItem;
                break;
            }
        }

        return $Item;
    }

    public function findRightItemByPath($path)
    {
        $Items = null;
        $RightItems = $this->getRightItems();
        foreach ($RightItems as $RightItem) {
            if ($RightItem->getPath() == $path) {
                $Items = $RightItem;
                break;
            }
        }

        return $Items;
    }

    public function findLeftItemsByName($name)
    {
        $Items = [];
        $LeftItems = $this->getLeftItems();
        foreach ($LeftItems as $LeftItem) {
            if ($LeftItem->getName() == $name) {
                $Items[] = $LeftItem;
            }
        }

        return $Items;
    }

    public function findRightItemsByName($name)
    {
        $Items = [];
        $RightItems = $this->getRightItems();
        foreach ($RightItems as $RightItem) {
            if ($RightItem->getName() == $name) {
                $Items[] = $RightItem;
            }
        }

        return $Items;
    }

    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
        return $this;
    }

    public function setStartingPath($startingPath = '')
    {
        $this->startingPath = $startingPath;
        return $this;
    }

} 