<?php
namespace SFramework\Views\DataGrid;


class ViewChangeRender extends ViewDecoration {

    /** @var array[] */
    public $changes;

    public function __construct(array $changes) {
        $this->changes = $changes;
    }

    public function currentRender() {
        foreach ($this->changes as $change) {
            /** @var ViewDecoration $view */
            list($value, $view) = $change;
            if ($value == $this->getValue()) {
                $view->render();
                break;
            }
        }
    }

}