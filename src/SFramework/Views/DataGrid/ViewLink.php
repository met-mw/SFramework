<?php
namespace SFramework\Views\DataGrid;


class ViewLink extends ViewDecoration {

    /** @var string Формат: /path/to/{label}/ */
    public $urlTemplate;

    public function __construct($urlTemplate, array $realValue = []) {
        $this->urlTemplate = $urlTemplate;
        $this->setAdditionalData($realValue);
    }

    public function currentRender() {
        ?><a target="_blank" href="<?= str_replace('{label}', !empty($this->getAdditionalData()) ? reset($this->getAdditionalData()) : $this->getValue(), $this->urlTemplate) ?>"><?= $this->getValue() ?></a><?
    }

}