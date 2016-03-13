<?php
namespace SFramework\Views\DataGrid;


class ViewChange extends ViewDecoration {

    /** @var array */
    public $changes;
    /** @var mixed */
    public $default;

    public function __construct($default, array $changes) {
        $this->changes = $changes;
        $this->default = $default;
    }

    public function currentRender() {
        foreach ($this->changes as $change) {
            list($value, $display) = $change;
            if ($value == $this->getValue()) {
                echo $display;
                return;
            }
        }

        echo $this->default;
    }

}