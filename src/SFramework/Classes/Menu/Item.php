<?php
namespace SFramework\Classes\Menu;


class Item {

    /** @var string */
    private $name;
    /** @var string */
    private $tooltip;
    /** @var string */
    private $path;

    /** @var Item[] */
    private $childItems = [];
    /** @var Item|null */
    private $parentItem = null;

    public function __construct($name, $path, $tooltip = '') {
        $this->name = $name;
        $this->path = $path;
        $this->tooltip = $tooltip;
    }

    /**
     * @param $name
     * @param $path
     * @param string $tooltip
     *
     * @return Item
     */
    public function addChildItem($name, $path, $tooltip = '') {
        $item = new Item($name, $path, $tooltip);
        $item->setParentItem($this);
        $this->childItems[] = $item;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function getTooltip() {
        return $this->tooltip;
    }

    public function getPath() {
        return $this->path;
    }

    public function getRealPath() {
        $pathParts = [$this->getPath()];
        $item = $this;
        do {
            $item = $item->getParentItem();
            $pathParts[] = $item->getPath();
        } while ($item->hasParentItem());

        return '/' . implode('/', array_reverse($pathParts));
    }

    public function getParentItem() {
        return $this->parentItem;
    }

    public function getChildItem($index) {
        return $this->childItems[$index];
    }

    public function getChildItems() {
        return $this->childItems;
    }

    public function findChildItemByPath($path) {
        $item = null;
        foreach ($this->childItems as $childItem) {
            if ($childItem->getPath() == $path) {
                $item = $childItem;
                break;
            }
        }

        return $item;
    }

    public function setParentItem(Item $parentItem) {
        $this->parentItem = $parentItem;
    }

    public function hasParentItem() {
        return !is_null($this->getParentItem());
    }

} 