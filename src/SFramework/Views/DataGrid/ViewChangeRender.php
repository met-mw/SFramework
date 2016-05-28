<?php
namespace SFramework\Views\DataGrid;


class ViewChangeRender extends ViewDecoration
{

    /** @var array[] */
    public $changes;
    /** @var ViewDecoration */
    public $DefaultViewDecoration;

    public function __construct(ViewDecoration $DefaultViewDecoration, array $changes)
    {
        $this->changes = $changes;
        $this->DefaultViewDecoration = $DefaultViewDecoration;
    }

    public function currentRender()
    {
        foreach ($this->changes as $change) {
            /** @var ViewDecoration $view */
            list($value, $view) = $change;
            if ($value == $this->getValue()) {
                $view->render();
                return;
            }
        }

        $this->DefaultViewDecoration->render();
    }

}