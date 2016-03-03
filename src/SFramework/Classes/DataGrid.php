<?php
namespace SFramework\Classes;


use SFramework\Classes\DataGrid\Action;
use SFramework\Classes\DataGrid\DataSet;
use SFramework\Classes\DataGrid\Header;

class DataGrid {

    /** @var string */
    protected $key;
    /** @var string */
    protected $caption;
    /** @var string */
    protected $description;
    /** @var Header[] */
    protected $headers = [];

    /** @var DataSet[] */
    protected $dataSets = [];

    /** @var Action[] */
    protected $actions = [];

    public function __construct($key, $caption) {
        $this->setKey($key)
            ->setCaption($caption)
        ;
    }

    public function addAction(Action $action) {
        $this->actions[] = $action;
        return $this;
    }

    public function addHeader(Header $header) {
        $this->headers[] = $header;
        return $this;
    }

    public function addDataSet(DataSet $dataSet) {
        $this->dataSets[] = $dataSet;
        return $this;
    }

    public function getFilterConditions() {
        $conditions = '';
        foreach ($this->getHeaders() as $header) {
            $headerValue = $header->getFilterValue();
            if ($header->isFiltered() && $headerValue != '') {
                $conditions .= $conditions == '' ? ' ' : ' and';
                $conditions .= " {$header->getKey()} like '%{$header->getFilterValue()}%'";
            }
        }

        return $conditions;
    }

    public function hasFiltered() {
        $result = false;
        foreach ($this->getHeaders() as $header) {
            if ($header->isFiltered()) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    public function hasGroupActions() {
        foreach ($this->getActions() as $action) {
            if ($action->isGroup()) {
                return true;
            }
        }

        return false;
    }

    public function getGroupActions() {
        /** @var Action[] $groupActions */
        $groupActions = [];
        foreach ($this->getActions() as $action) {
            if (!$action->isGroup()) {
                continue;
            }

            $groupActions[] = $action;
        }

        return $groupActions;
    }

    public function getKey() {
        return $this->key;
    }

    public function getCaption() {
        return $this->caption;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getActions() {
        return $this->actions;
    }

    public function getHeaderKeys() {
        $keys = [];
        foreach ($this->getHeaders() as $header) {
            $keys[] = $header->getKey();
        }

        return $keys;
    }

    public function getData() {
        $data = [];
        foreach ($this->dataSets as $dataSet) {
            $data = array_merge($data, $dataSet->asArray());
        }

        return $data;
    }

    public function setCaption($caption) {
        $this->caption = $caption;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setKey($key) {
        $this->key = $key;
        return $this;
    }

    /**
     * @param DataSet[] $dataSets
     *
     * @return $this
     */
    public function setDataSets(array $dataSets) {
        $this->dataSets = $dataSets;
        return $this;
    }

} 