<?php
namespace SFramework\Classes\DataGrid;


abstract class DataSet {

    protected $dataSource;

    /**
     * @return array[]
     */
    abstract public function asArray();

} 