<?php
namespace SFramework\Classes;


class Breadcrumb {

    protected $name;
    protected $path;
    protected $isParam;

    public function __construct($name, $path, $isParam = false)
    {
        $this->setName($name)
            ->setPath($path)
            ->setIsParam($isParam);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param $name
     *
     * @return Breadcrumb
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $path
     *
     * @return Breadcrumb
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @param $isParam
     *
     * @return Breadcrumb
     */
    public function setIsParam($isParam)
    {
        $this->isParam = $isParam;
        return $this;
    }

    public function isParam()
    {
        return $this->isParam;
    }

} 