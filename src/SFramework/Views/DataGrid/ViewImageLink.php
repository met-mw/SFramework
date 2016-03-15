<?php


namespace SFramework\Views\DataGrid;


use SFramework\Classes\CoreFunctions;

class ViewImageLink extends ViewDecoration {

    /** @var bool */
    public $blank;
    /** @var array */
    public $attributesLink = [];
    public $attributesImage = [];

    public function __construct($urlTemplate, $blank = false, $valueFieldName = null, array $attributesLink = [], array $attributesImage = []) {
        $this->optional[] = 'valueFieldName';

        $this->blank = $blank;
        $this->attributesLink = $attributesLink;
        $this->attributesImage = $attributesImage;
    }

    public function currentRender() {
        ?>
        <a<?= !empty($this->attributesLink) ? ' ' . CoreFunctions::tagAttributesToString($this->attributesLink) : '' ?><?= $this->blank ? ' target="_blank"' : '' ?> href="<?= $this->getValue() ?>">
            <img<?= !empty($this->attributesImage) ? ' ' . CoreFunctions::tagAttributesToString($this->attributesImage) : '' ?> src="<?= $this->getValue() ?>"/>
        </a>
        <?
    }

} 