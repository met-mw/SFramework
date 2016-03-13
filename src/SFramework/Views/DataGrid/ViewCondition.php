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
            $field = $condition['field'];
            $value = $condition['value'];
            /** @var ViewDecoration $view */
            $view = $condition['view'];
            $view->setValue($this->getValue());
            $view->setAdditionalData($this->getAdditionalData());

            if ($this->additionalData[$field] == $value) {
                $view->render();
                return;
            }
        }

        $this->default->render();
    }

}