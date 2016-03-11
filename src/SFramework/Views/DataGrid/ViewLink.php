<?php
namespace SFramework\Views\DataGrid;


class ViewLink extends ViewDecoration {

    /** @var string Формат: /path/to/{label}/ */
    public $urlTemplate;
    /** @var string|null */
    public $valueFieldName;

    public function __construct($urlTemplate, $valueFieldName = null) {
        $this->optional[] = 'valueFieldName';

        $this->urlTemplate = $urlTemplate;
        $this->valueFieldName = $valueFieldName;
    }

    public function currentRender() {
        $additionalData = $this->getAdditionalData();
        $label = $this->getValue();
        if ($this->valueFieldName !== null && isset($additionalData[$this->valueFieldName])) {
            $label = $additionalData[$this->valueFieldName];
        }

        ?><a target="_blank" href="<?= str_replace('{label}', $label, $this->urlTemplate) ?>"><?= $this->getValue() ?></a><?
    }

}