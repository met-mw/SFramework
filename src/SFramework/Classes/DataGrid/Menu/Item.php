<?php
namespace SFramework\Classes\DataGrid\Menu;


class Item extends Element  {

    /** @var string */
    protected $displayName;
    /** @var string */
    protected $url;

    public function __construct($displayName, $url) {
        $this->setDisplayName($displayName);
        $this->setUrl($url);
    }

    public function getDisplayName() {
        return $this->displayName;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setDisplayName($displayName) {
        $this->displayName = $displayName;
        return $this;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

} 