<?php
namespace SFramework\Classes\DataGrid;


use SFramework\Classes\CoreFunctions;

/**
 * Class Action
 * @package SFramework\Classes\DataGrid
 */
class Action
{

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
    /** @var array */
    protected $additionalParameters = [];
    /** @var string[] */
    protected $attributes = [];
    /** @var bool */
    protected $group = false;
    /** @var bool */
    protected $ajax = false;

    public function __construct($paramName, $uri, $name, $displayName, array $additionalParameters = [], array $attributes = [], $title = '', $group = false, $ajax = false)
    {
        $this->setURI($uri)
            ->setParamName($paramName)
            ->setName($name)
            ->setDisplayName($displayName)
            ->setAdditionalParameters($additionalParameters)
            ->setAttributes($attributes)
            ->setTitle($title)
            ->setGroup($group)
            ->setAJAX($ajax);
    }

    public function buildGroupURI($groupActionName = 'group')
    {
        $uri = $this->getURI();
        $parts = explode('?', $uri);
        $parts[0] .= $groupActionName;
        $uri = implode('?', $parts);

        return $uri;
    }

    public function buildAttributes()
    {
        return CoreFunctions::tagAttributesToString($this->getAttributes());
    }

    public function getParamName()
    {
        return $this->paramName;
    }

    public function getURI()
    {
        return $this->uri;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getAdditionalParameters()
    {
        return $this->additionalParameters;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function isGroup()
    {
        return $this->group;
    }

    public function isAjax()
    {
        return $this->ajax;
    }

    /**
     * Установить имя параметра, передаваемое на сервер (Ключ колонки)
     *
     * @param string $paramName
     *
     * @return Action
     */
    public function setParamName($paramName)
    {
        $this->paramName = $paramName;
        return $this;
    }

    /**
     * Установить адрес
     *
     * @param string $uri
     *
     * @return Action
     */
    public function setURI($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * Установить имя (применяется при генерации имени поля формы)
     *
     * @param string $name
     *
     * @return Action
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Установить название для отображения
     *
     * @param string $displayName
     *
     * @return Action
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * Установить "всплывающую" подсказку
     *
     * @param string $title
     *
     * @return Action
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param array $additionalParameters
     *
     * @return Action
     */
    public function setAdditionalParameters(array $additionalParameters)
    {
        $this->additionalParameters = $additionalParameters;
        return $this;
    }

    /**
     * Установить аттрибуты
     *
     * @param array $attributes
     *
     * @return Action
     */
    public function setAttributes(array $attributes = [])
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Установить флаг группового действия
     *
     * @param bool $group
     *
     * @return Action
     */
    public function setGroup($group = false)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * Установить флаг AJAX
     *
     * @param bool $ajax
     *
     * @return Action
     */
    public function setAJAX($ajax = false)
    {
        $this->ajax = $ajax;
        return $this;
    }

} 