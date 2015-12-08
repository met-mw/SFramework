<?php
namespace SFramework\Classes;


use SFramework\Classes\Menu\Item;

class Menu {

    /** @var Item[] */
    private $leftItems = [];
    /** @var Item[] */
    private $rightItems = [];

    /** @var string */
    private $projectName;
    /** @var string */
    private $startingPath;

    public function __construct($projectName, $startingPath = '') {
        $this->projectName = $projectName;
        $this->startingPath = $startingPath;
    }

    public function addLeftItem($name, $path, $tooltip = '') {
        $this->leftItems[] = new Item($name, $path, $tooltip);
        return $this;
    }

    public function addRightItem($name, $path, $tooltip = '') {
        $this->rightItems[] = new Item($name, $path, $tooltip);
        return $this;
    }

    public function getProjectName() {
        return $this->projectName;
    }

    public function getStartingPath() {
        return $this->startingPath;
    }

    public function getLeft() {
        return $this->leftItems;
    }

    public function getRight() {
        return $this->rightItems;
    }

    public function getLeftItem($index) {
        return $this->leftItems[$index];
    }

    public function getRightItem($index) {
        return $this->rightItems[$index];
    }

    public function findLeftItemByPath($path) {
        $item = null;
        foreach ($this->getLeft() as $leftItem) {
            if ($leftItem->getPath() == $path) {
                $item = $leftItem;
                break;
            }
        }

        return $item;
    }

    public function findRightItemByPath($path) {
        $item = null;
        foreach ($this->getRight() as $rightItem) {
            if ($rightItem->getPath() == $path) {
                $item = $rightItem;
                break;
            }
        }

        return $item;
    }

    public function findLeftItemsByName($name) {
        $items = [];
        foreach ($this->getLeft() as $leftItem) {
            if ($leftItem->getName() == $name) {
                $items[] = $leftItem;
            }
        }

        return $items;
    }

    public function findRightItemsByName($name) {
        $items = [];
        foreach ($this->getRight() as $rightItem) {
            if ($rightItem->getName() == $name) {
                $items[] = $rightItem;
            }
        }

        return $items;
    }

    public function setProjectName($projectName) {
        $this->projectName = $projectName;
        return $this;
    }

    public function setStartingPath($startingPath = '') {
        $this->startingPath = $startingPath;
        return $this;
    }

} 