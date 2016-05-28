<?php
namespace SFramework\Classes;


use SFramework\Classes\DataGrid\Action;
use SFramework\Classes\DataGrid\DataSet;
use SFramework\Classes\DataGrid\Header;
use SFramework\Classes\DataGrid\Menu;
use SFramework\Views\ViewPagination;
use SORM\DataSource;

/**
 * Class DataGrid
 * @package SFramework\Classes
 */
class DataGrid
{

    const DEFAULT_ITEMS_PER_PAGE = 20;

    /** @var Menu */
    protected $Menu;

    /** @var string */
    protected $name;
    /** @var string */
    protected $action;
    /** @var string */
    protected $key;
    /** @var string */
    protected $caption;
    /** @var string */
    protected $description;
    /** @var Header[] */
    protected $Headers = [];

    /** @var DataSet[] */
    protected $DataSets = [];

    /** @var Action[] */
    protected $Actions = [];

    protected $hiddenFields = [];

    /** @var Pagination */
    public $Pagination;
    protected $itemsPerPage = DEFAULT_INCLUDE_PATH;

    public function __construct($name, $action, $key, $caption, $pageNumber, $itemsPerPage = null, $description = '')
    {
        $this->setName($name)
            ->setAction($action)
            ->setKey($key)
            ->setCaption($caption)
            ->setDescription($description)
            ->setItemsPerPage($itemsPerPage ? $itemsPerPage : self::DEFAULT_ITEMS_PER_PAGE);
        ;

        $this->Menu = new Menu();
        $this->Pagination = new Pagination(DataSource::getCurrent(), $pageNumber ? $pageNumber : 1, $this->getItemsPerPage());
    }

    public function getHiddenFields()
    {
        return $this->hiddenFields;
    }

    /**
     * @param $name
     * @param $value
     *
     * @return DataGrid
     */
    public function addHiddenField($name, $value)
    {
        $this->hiddenFields[$name] = $value;
        return $this;
    }

    /**
     * @param array $hiddenFields
     *
     * @return DataGrid
     */
    public function setHiddenFields(array $hiddenFields = [])
    {
        $this->hiddenFields = $hiddenFields;
        return $this;
    }

    public function fillPager(ViewPagination $view)
    {
        $view->pagesCount = $this->Pagination->getPagesCount();
        $view->currentURL = $this->Pagination->getUrl();
        $view->currentPage = $this->Pagination->getCurrentPage();
        $view->parameterName = $this->Pagination->getParameterName();
    }

    public function preparePager()
    {
        $this->Pagination->prepare();
    }

    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMenu()
    {
        return $this->Menu;
    }

    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    public function addAction(Action $Action)
    {
        $this->Actions[] = $Action;
        return $this;
    }

    public function addHeader(Header $Header)
    {
        $this->Headers[] = $Header;
        return $this;
    }

    public function addDataSet(DataSet $DataSet)
    {
        $this->DataSets[] = $DataSet;
        return $this;
    }

    public function getFilterConditionsArray($tableName = null)
    {
        $conditions = [];
        foreach ($this->getHeaders() as $header) {
            $headerValue = $header->getFilterValue();
            if ($header->isFiltered() && $headerValue != '') {
                $condition = '';

                if ($header->getFilterTableName() !== null) {
                    $condition .= "`{$header->getFilterTableName()}`.";
                } elseif ($tableName !== null) {
                    $condition .= "`{$tableName}`.";
                }

                if ($header->getFilterFieldAlias() !== null) {
                    $condition .= "`{$header->getFilterFieldAlias()}`";
                } else {
                    $condition .= "`{$header->getKey()}`";
                }

                $condition .= " like '%{$header->getFilterValue()}%'";
                $conditions[] = $condition;
            }
        }

        return $conditions;
    }

    public function getFilterConditions($tableName = null)
    {
        $conditions = '';
        foreach ($this->getHeaders() as $header) {
            $headerValue = $header->getFilterValue();
            if ($header->isFiltered() && $headerValue != '') {
                $conditions .= $conditions == '' ? ' ' : ' and';

                if ($header->getFilterTableName() !== null) {
                    $conditions .= "`{$header->getFilterTableName()}`.";
                } elseif ($tableName !== null) {
                    $conditions .= "`{$tableName}`.";
                } else {
                    $conditions .= ' ';
                }

                if ($header->getFilterFieldAlias() !== null) {
                    $conditions .= "`{$header->getFilterFieldAlias()}`";
                } else {
                    $conditions .= "`{$header->getKey()}`";
                }

                $conditions .= " like '%{$header->getFilterValue()}%'";
            }
        }

        return $conditions;
    }

    public function hasFiltered()
    {
        $result = false;
        foreach ($this->getHeaders() as $header) {
            if ($header->isFiltered()) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    public function hasGroupActions()
    {
        $Actions = $this->getActions();
        foreach ($Actions as $Action) {
            if ($Action->isGroup()) {
                return true;
            }
        }

        return false;
    }

    public function getGroupActions()
    {
        /** @var Action[] $GroupActions */
        $GroupActions = [];
        $Actions = $this->getActions();
        foreach ($Actions as $Action) {
            if (!$Action->isGroup()) {
                continue;
            }

            $GroupActions[] = $Action;
        }

        return $GroupActions;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getCaption()
    {
        return $this->caption;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getHeaders()
    {
        return $this->Headers;
    }

    public function getActions()
    {
        return $this->Actions;
    }

    public function getHeaderKeys()
    {
        $keys = [];
        $Headers = $this->getHeaders();
        foreach ($Headers as $Header) {
            $keys[] = $Header->getKey();
        }

        return $keys;
    }

    public function getData()
    {
        $data = [];
        foreach ($this->DataSets as $DataSet) {
            $data = array_merge($data, $DataSet->asArray());
        }

        return $data;
    }

    /**
     * Наименование таблицы (используется для именования полей формы таблицы)
     *
     * @param string $name
     *
     * @return DataGrid $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * URL формы
     *
     * @param string $url
     *
     * @return DataGrid $this
     */
    public function setAction($url)
    {
        $this->action = $url;
        return $this;
    }

    /**
     * @param Menu $Menu
     *
     * @return DataGrid $this
     */
    public function setMenu(Menu $Menu)
    {
        $this->Menu = $Menu;
        return $this;
    }

    /**
     * @param string $caption
     *
     * @return DataGrid $this
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
        return $this;
    }

    /**
     * @param string $description
     *
     * @return DataGrid $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $key
     *
     * @return DataGrid $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @param DataSet[] $DataSets
     *
     * @return DataGrid $this
     */
    public function setDataSets(array $DataSets)
    {
        $this->DataSets = $DataSets;
        return $this;
    }

} 