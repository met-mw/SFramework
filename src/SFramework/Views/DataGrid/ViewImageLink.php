<?php


namespace SFramework\Views\DataGrid;


use SFramework\Classes\CoreFunctions;

class ViewImageLink extends ViewDecoration {

    /** @var string Формат: /path/to/{label}/ */
    public $urlTemplate;
    /** @var string|null */
    public $valueFieldName;
    /** @var bool */
    public $blank;
    /** @var array */
    public $attributesLink = [];
    public $attributesImage = [];

    public function __construct($urlTemplate, $blank = false, $valueFieldName = null, array $attributesLink = [], array $attributesImage = []) {
        $this->optional[] = 'valueFieldName';

        $this->urlTemplate = $urlTemplate;
        $this->blank = $blank;
        $this->valueFieldName = $valueFieldName;
        $this->attributesLink = $attributesLink;
        $this->attributesImage = $attributesImage;
    }

    public function currentRender() {
        $additionalData = $this->getAdditionalData();
        $label = $this->getValue();
        if ($this->valueFieldName !== null && isset($additionalData[$this->valueFieldName])) {
            $label = $additionalData[$this->valueFieldName];
        }

        ?>
        <a<?= !empty($this->attributesLink) ? ' ' . CoreFunctions::tagAttributesToString($this->attributesLink) : '' ?><?= $this->blank ? ' target="_blank"' : '' ?> href="<?= str_replace('{label}', $label, $this->urlTemplate) ?>"><?= $this->getValue() ?>
            <img<?= !empty($this->attributesImage) ? ' ' . CoreFunctions::tagAttributesToString($this->attributesImage) : '' ?> src="<?= $this->getValue() ?>"/>
        </a>
        <?
    }

} 