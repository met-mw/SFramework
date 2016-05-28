<?php
namespace SFramework\Classes\Menu;


class Item
{

    /** @var string */
    private $name;
    /** @var string */
    private $tooltip;
    /** @var string */
    private $path;

    /** @var Item[] */
    private $ChildItems = [];
    /** @var Item|null */
    private $ParentItem = null;

    public function __construct($name, $path, $tooltip = '')
    {
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
    public function addChildItem($name, $path, $tooltip = '')
    {
        $item = new Item($name, $path, $tooltip);
        $item->setParentItem($this);
        $this->ChildItems[] = $item;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTooltip()
    {
        return $this->tooltip;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getRealPath()
    {
        $pathParts = [$this->getPath()];
        $item = $this;
        do {
            $item = $item->getParentItem();
            $pathParts[] = $item->getPath();
        } while ($item->hasParentItem());

        return '/' . implode('/', array_reverse($pathParts));
    }

    public function getParentItem()
    {
        return $this->ParentItem;
    }

    public function getChildItem($index)
    {
        return $this->ChildItems[$index];
    }

    public function getChildItems()
    {
        return $this->ChildItems;
    }

    public function findChildItemByPath($path)
    {
        $item = null;
        foreach ($this->ChildItems as $ChildItem) {
            if ($ChildItem->getPath() == $path) {
                $item = $ChildItem;
                break;
            }
        }

        return $item;
    }

    public function setParentItem(Item $ParentItem)
    {
        $this->ParentItem = $ParentItem;
    }

    public function hasParentItem()
    {
        return !is_null($this->getParentItem());
    }

} 