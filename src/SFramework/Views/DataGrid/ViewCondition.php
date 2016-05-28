<?php
namespace SFramework\Views\DataGrid;


class ViewCondition extends ViewDecoration
{

    /** @var array[] */
    public $conditions;
    /** @var ViewDecoration */
    public $DefaultViewDecoration;

    public function __construct(ViewDecoration $DefaultViewDecoration, array $conditions, array $additionalData = [])
    {
        $this->conditions = $conditions;
        $this->DefaultViewDecoration = $DefaultViewDecoration;
    }

    public function currentRender()
    {
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

        $this->DefaultViewDecoration->setValue($this->getValue());
        $this->DefaultViewDecoration->setAdditionalData($this->getAdditionalData());
        $this->DefaultViewDecoration->render();
    }

}