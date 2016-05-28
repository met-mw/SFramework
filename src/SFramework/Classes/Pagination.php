<?php
namespace SFramework\Classes;


use SORM\Interfaces\InterfaceDriver;
use SORM\Tools\Builder\Select;

class Pagination
{

    /** @var int */
    protected $fullCount = 0;
    /** @var int|null  */
    protected $limit = null;
    /** @var int|null */
    protected $linksLimit = null;
    /** @var int|null */
    protected $current = null;
    /** @var int|null */
    protected $pagesCount = null;
    protected $parameterName = 'page';

    /** @var Select */
    protected $Builder;
    /** @var InterfaceDriver */
    protected $Driver;

    public function __construct(InterfaceDriver $Driver, $current = null, $limit = null, $parameterName = 'page')
    {
        $this->Driver = $Driver;
        $this->Builder = new Select();
        $this->parameterName = $parameterName;
        $this->current = $current;
        $this->limit = $limit;
    }

    /**
     * @param int $linksLimit
     */
    public function setLinksLimit($linksLimit)
    {
        $this->linksLimit = $linksLimit;
    }

    /**
     * @param int $current Порядковый номер активной страницы
     *
     * @return $this
     */
    public function setCurrent($current)
    {
        $this->current = $current;
        return $this;
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return $this
     */
    public function prepare()
    {
        $this->calcFullRowsCount();
        $this->calcPagesCount();

        return $this;
    }

    public function getOffset()
    {
        return ((int)$this->current == 0 ? (int)$this->current : (int)$this->current - 1) * $this->limit;
    }

    public function getLimit()
    {
        return (int)$this->limit;
    }

    public function getUrl()
    {
        parse_str($_SERVER['QUERY_STRING'], $queryVars );
        if (isset($queryVars[$this->parameterName])) {
            unset($queryVars[$this->parameterName]);
        }

        return $_SERVER['REDIRECT_URL'] . '?' . http_build_query($queryVars);
    }

    public function getPagesCount()
    {
        return $this->pagesCount;
    }

    public function getParameterName()
    {
        return $this->parameterName;
    }

    public function getCurrentPage()
    {
        return $this->current;
    }

    /**
     * @return $this
     */
    protected function calcFullRowsCount()
    {
        $Builder = new Select();
        $Builder->field('FOUND_ROWS()', 'count');
        $query = $Builder->build();
        $this->Driver->query($query);
        $data = $this->Driver->fetchAssoc();
        $this->fullCount = (int)$data[0]['count'];

        return $this;
    }

    protected function calcPagesCount()
    {
        $this->pagesCount = ceil($this->fullCount / $this->limit);
    }

} 