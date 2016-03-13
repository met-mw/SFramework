<?php
namespace SFramework\Views\DataGrid;


class ViewCondition extends ViewDecoration {

    /** @var array[] */
    public $conditions;
    /** @var ViewDecoration */
    public $default;

    public function __construct(ViewDecoration $default, array $conditions, array $additionalData = []) {
        $this->conditions = $conditions;
        $this->default = $default;
    }

    public function currentRender() {
        foreach ($this->conditions as $condition) {
            if ($this->additionalData[$condition['field']] == $condition['value']) {
                $condition['view']->render();
                return;
            }
        }

        $this->default->render();
    }

}