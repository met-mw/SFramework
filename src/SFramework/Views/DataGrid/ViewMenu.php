<?php
namespace SFramework\Views\DataGrid;


use SFramework\Classes\DataGrid\Menu;
use SFramework\Classes\DataGrid\Menu\Item;
use SFramework\Classes\DataGrid\Menu\Separator;
use SFramework\Classes\View;
use SFramework\Views\DataGrid\Menu\ViewItem;
use SFramework\Views\DataGrid\Menu\ViewSeparator;

class ViewMenu extends View
{

    /** @var Menu */
    public $Menu;

    public function currentRender()
    {
        echo $this->Menu->getName() . ': ';
        foreach ($this->Menu->getElements() as $element) {
            if ($element instanceof Separator){
                (new ViewSeparator())->render();
            } elseif ($element instanceof Item) {
                (new ViewItem($element))->render();
            }
        }
    }

}