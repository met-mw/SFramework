<?php
namespace SFramework\Views\DataGrid;


class ViewLink extends ViewDecoration {

    /** @var string Формат: /path/to/{label}/ */
    public $urlTemplate;

    public function __construct($urlTemplate) {
        $this->urlTemplate = $urlTemplate;
    }

    public function currentRender() {
        ?><a target="_blank" href="<?= str_replace('{label}', $this->getValue(), $this->urlTemplate) ?>"><?= $this->getValue() ?></a><?
    }

}