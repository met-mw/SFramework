<?php
namespace SFramework\Classes\DataGrid;


use SFramework\Views\DataGrid\ViewDecoration;

class Header {

    /** @var string */
    protected $key;
    /** @var string */
    protected $displayName;
    /** @var string[] Атрибуты ['name' => 'value', ...] */
    protected $attributes = [];
    /** @var string[] Атрибуты значений ['name' => 'value', ...] */
    protected $valueAttributes = [];
    /** @var bool */
    protected $filtered = false;
    protected $filterValue = '';
    /** @var ViewDecoration */
    protected $decoration = null;

    public function __construct($key, $displayName, ViewDecoration $decoration = null, array $attributes = [], array $valueAttributes = [], $filtered = false, $filterValue = '') {
        $this->setKey($key)
            ->setDisplayName($displayName)
            ->setFiltered($filtered)
            ->setFilterValue($filterValue)
            ->setAttributes($attributes)
            ->setValueAttributes($valueAttributes)
            ->setDecoration($decoration);
    }

    public function decorate($value) {
        $result = $value;
        if (!is_null($this->getDecoration())) {
            ob_start();
            $this->getDecoration()
                ->setValue($value)
                ->render();
            $result = ob_get_contents();
            ob_end_clean();
        }

        return $result;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function addAttribute($name, $value) {
        $this->attributes[$name] = $value;
        return $this;
    }

    private function buildArrayToString(array $source, $delimiter = ' ') {
        $attributes = [];
        foreach ($source as $name => $value) {
            $attributes[] = "{$name}=\"{$value}\"";
        }

        return implode($delimiter, $attributes);
    }

    public function buildAttributes() {
        return $this->buildArrayToString($this->getAttributes());
    }

    public function buildValueAttributes() {
        return $this->buildArrayToString($this->getValueAttributes());
    }

    public function getKey() {
        return $this->key;
    }

    public function getFilterName() {
        return "filter-{$this->getKey()}";
    }

    public function getDisplayName() {
        return $this->displayName;
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function getValueAttributes() {
        return $this->valueAttributes;
    }

    public function getFilterValue() {
        return $this->filterValue;
    }

    public function getDecoration() {
        return $this->decoration;
    }

    public function isFiltered() {
        return $this->filtered == true;
    }

    public function setKey($key) {
        $this->key = $key;
        return $this;
    }

    public function setDisplayName($value) {
        $this->displayName = $value;
        return $this;
    }

    /**
     * @param string[] $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes = []) {
        $this->attributes = $attributes;
        return $this;
    }

    public function setValueAttributes(array $valueAttributes = []) {
        $this->valueAttributes = $valueAttributes;
        return $this;
    }

    public function setFiltered($filtered = false) {
        $this->filtered = $filtered;
        return $this;
    }

    public function setFilterValue($filterValue) {
        $this->filterValue = $filterValue;
        return $this;
    }

    public function setDecoration(ViewDecoration $decoration = null) {
        $this->decoration = $decoration;
    }

} 