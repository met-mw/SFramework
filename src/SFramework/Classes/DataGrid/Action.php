<?php
namespace SFramework\Classes\DataGrid;


class Action {

    /** @var string */
    protected $paramName;
    /** @var string */
    protected $uri;
    /** @var string */
    protected $name;
    /** @var string */
    protected $displayName;
    /** @var string */
    protected $title;
    /** @var string[] */
    protected $classes = [];
    /** @var bool */
    protected $group = false;

    public function __construct($paramName, $uri, $name, $displayName, $title = '', array $classes = [], $group = false) {
        $this->setURI($uri)
            ->setParamName($paramName)
            ->setName($name)
            ->setDisplayName($displayName)
            ->setTitle($title)
            ->setClasses($classes)
            ->setGroup($group);
    }

    public function buildURI($value = null) {
        $uri = $this->getURI();
        if (!is_null($value)) {
            $uri .= mb_strpos($uri, '?') === false ? '&' : '?';
            $uri .= "{$this->getParamName()}={$value}";
        }

        return $uri;
    }

    public function buildClasses() {
        $classes = '';
        foreach ($this->getClasses() as $class) {
            if ($classes != '') {
                $classes .= ' ';
            }

            $classes .= $class;
        }

        return $classes;
    }

    public function addClass($class) {
        $this->classes[] = $class;
        return $this;
    }

    public function getParamName() {
        return $this->paramName;
    }

    public function getURI() {
        return $this->uri;
    }

    public function getName() {
        return $this->name;
    }

    public function getDisplayName() {
        return $this->displayName;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getClasses() {
        return $this->classes;
    }

    public function isGroup() {
        return $this->group;
    }

    public function setParamName($paramName) {
        $this->paramName = $paramName;
        return $this;
    }

    public function setURI($uri) {
        $this->uri = $uri;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setDisplayName($displayName) {
        $this->displayName = $displayName;
        return $this;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setClasses(array $classes = []) {
        $this->classes = $classes;
        return $this;
    }

    public function setGroup($group = false) {
        $this->group = $group;
        return $this;
    }

} 