<?php
namespace SFramework\Classes\DataGrid\DataSet;


use SFramework\Classes\DataGrid\DataSet;

class ArrayDataSet extends DataSet
{

    public function __construct(array $array)
    {
        $this->setDataSource($array);
    }

    public function addDataSourceRow(array $row)
    {
        $this->dataSource[] = $row;
        return $this;
    }

    public function getDataSource()
    {
        return $this->dataSource;
    }

    public function setDataSource(array $array)
    {
        $this->dataSource = $array;
        return $this;
    }

    /**
     * @return array[]
     */
    public function asArray()
    {
        return $this->getDataSource();
    }

}