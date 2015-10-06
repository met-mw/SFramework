<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 03.10.15
 */

namespace kernel\orm\interfaces;


interface Interface_Entity {

    /**
     * @param int $primaryKey Первичный ключ
     *
     * @return static[]
     */
    public function load($primaryKey);

    public function getPrimaryKey();

    public function commit();

    public function delete();

} 