<?php
namespace SFramework\Classes\DataGrid\DataSet;


use SFramework\Classes\DataGrid\DataSet;
use SORM\Entity;

class SORMDataSet extends DataSet
{

    public function __construct(array $entities = [])
    {
        $this->setDataSource($entities);
    }

    public function addDataSourceItem(Entity $entity)
    {
        $this->dataSource[] = $entity;
        return $this;
    }

    /**
     * @return Entity[]
     */
    public function getDataSource()
    {
        return $this->dataSource;
    }

    /**
     * @param Entity[] $entities
     *
     * @return $this
     */
    public function setDataSource(array $entities = [])
    {
        $this->dataSource = $entities;
        return $this;
    }

    public function asArray()
    {
        $result = [];
        foreach ($this->getDataSource() as $entity) {
            $row = [];
            foreach ($entity->getFields() as $field) {
                $row[$field->name] = $entity->{$field->name};
            }

            $result[] = $row;
        }

        return $result;
    }

}