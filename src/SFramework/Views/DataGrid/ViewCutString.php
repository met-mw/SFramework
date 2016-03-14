<?php
namespace SFramework\Views\DataGrid;


use SFramework\Classes\CoreFunctions;

class ViewCutString extends ViewDecoration {

    /** @var integer */
    public $offset;
    /** @var bool */
    public $stripTags;
    /** @var array */
    public $attributesLink = [];
    /** @var array */
    public $attributesFullContent = [];

    public function __construct($offset, $stripTags = true, array $attributesLink = [], array $attributesFullContent = []) {
        $this->attributesLink = $attributesLink;
        $this->attributesFullContent = $attributesFullContent;
        $this->offset = $offset;
        $this->stripTags = $stripTags;
    }

    public function currentRender() {
        $content = $this->stripTags ? strip_tags($this->getValue()) : $this->getValue();
        $content = mb_substr($content, 0, mb_strpos($content, ' ', $this->offset));
        ?><a<?= !empty($this->attributesLink) ? ' ' . CoreFunctions::tagAttributesToString($this->attributesLink) : '' ?>><?= $content ?>...</a><?
        ?><div<?= !empty($this->attributesFullContent) ? ' ' . CoreFunctions::tagAttributesToString($this->attributesFullContent) : '' ?>><?= $this->getValue() ?></div><?
    }

}