<?php


namespace SFramework\Classes\DataGrid\Menu;


class Element
{

    /** @var string[] */
    protected $attributes = [];

    public function setAttributes(array $attributes = [])
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function hasAttributes()
    {
        return !empty($this->getAttributes());
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function buildAttributes()
    {
        $attributes = [];
        foreach ($this->getAttributes() as $name => $value) {
            $attributes[] = "{$name}=\"{$value}\"";
        }

        return implode(' ', $attributes);
    }

} 