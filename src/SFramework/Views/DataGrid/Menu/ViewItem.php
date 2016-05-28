<?php
namespace SFramework\Views\DataGrid\Menu;


use SFramework\Classes\DataGrid\Menu\Item;
use SFramework\Classes\View;

class ViewItem extends View
{

    /** @var Item */
    public $Item;

    public function __construct(Item $Item)
    {
        $this->Item = $Item;
    }

    public function currentRender()
    {
        ?>
        <a href="<?= $this->Item->getUrl() ?>"<?= $this->Item->hasAttributes() ? ' ' . $this->Item->buildAttributes() : '' ?>><?= $this->Item->getDisplayName() ?></a>
        <?
    }

}