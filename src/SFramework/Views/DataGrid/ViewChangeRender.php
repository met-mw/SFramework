<?php
namespace SFramework\Views\DataGrid;


class ViewChangeRender extends ViewDecoration {

    /** @var array[] */
    public $changes;
    /** @var ViewDecoration */
    public $defaultViewDecoration;

    public function __construct(ViewDecoration $defaultViewDecoration, array $changes) {
        $this->changes = $changes;
        $this->defaultViewDecoration = $defaultViewDecoration;
    }

    public function currentRender() {
        foreach ($this->changes as $change) {
            /** @var ViewDecoration $view */
            list($value, $view) = $change;
            if ($value == $this->getValue()) {
                $view->render();
                return;
            }
        }

        $this->defaultViewDecoration->render();
    }

}