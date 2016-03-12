<?php
namespace SFramework\Views\DataGrid;


class ViewChange extends ViewDecoration {

    /** @var array */
    public $changes;

    public function __construct(array $changes) {
        $this->changes = $changes;
    }

    public function currentRender() {
        foreach ($this->changes as $change) {
            list($value, $display) = $change;
            if ($value == $this->getValue()) {
                echo $display;
                break;
            }
        }
    }

}