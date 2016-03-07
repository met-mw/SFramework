<?php
namespace SFramework\Classes\DataGrid;


use SFramework\Classes\CoreFunctions;

/**
 * Class Action
 * @package SFramework\Classes\DataGrid
 */
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
    protected $attributes = [];
    /** @var bool */
    protected $group = false;

    public function __construct($paramName, $uri, $name, $displayName, array $attributes = [], $title = '', $group = false) {
        $this->setURI($uri)
            ->setParamName($paramName)
            ->setName($name)
            ->setDisplayName($displayName)
            ->setAttributes($attributes)
            ->setTitle($title)
            ->setGroup($group);
    }

    public function buildURI($value = null) {
        $uri = $this->getURI();
        if (!is_null($value)) {
            $uri = CoreFunctions::addGETParamToURI($uri, $this->getParamName(), $value);
        }

        return $uri;
    }

    public function buildClasses() {
        CoreFunctions::tagAttributesToString($this->getAttributes());
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

    public function getAttributes() {
        return $this->attributes;
    }

    public function isGroup() {
        return $this->group;
    }

    /**
     * Установить имя параметра, передаваемое на сервер (Ключ колонки)
     *
     * @param string $paramName
     *
     * @return Action $this
     */
    public function setParamName($paramName) {
        $this->paramName = $paramName;
        return $this;
    }

    /**
     * Установить адрес
     *
     * @param string $uri
     *
     * @return Action $this
     */
    public function setURI($uri) {
        $this->uri = $uri;
        return $this;
    }

    /**
     * Установить имя (применяется при генерации имени поля формы)
     *
     * @param string $name
     *
     * @return Action $this
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Установить название для отображения
     *
     * @param string $displayName
     *
     * @return Action $this
     */
    public function setDisplayName($displayName) {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * Установить "всплывающую" подсказку
     *
     * @param string $title
     *
     * @return Action $this
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Установить аттрибуты
     *
     * @param array $attributes
     *
     * @return Action $this
     */
    public function setAttributes(array $attributes = []) {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Установить флаг группового действия
     *
     * @param bool $group
     *
     * @return Action $this
     */
    public function setGroup($group = false) {
        $this->group = $group;
        return $this;
    }

} 