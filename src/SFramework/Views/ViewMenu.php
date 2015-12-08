<?php
namespace SFramework\Views;


use SFramework\Classes\Menu;
use SFramework\Classes\Menu\Item;
use SFramework\Classes\View;

abstract class ViewMenu extends View {

    /** @var Menu */
    public $menu;

    abstract protected function renderItem(Item $item);

} 