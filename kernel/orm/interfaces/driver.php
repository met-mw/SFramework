<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 03.10.15
 */

namespace kernel\orm\interfaces;


interface Interface_Driver {

    static public function factory($className, $primaryKey = null);

    static public function cls();

    public function query($query);

    public function fetchAssoc();

    public function fetchRow();

    public function fetchFields();

    public function fetchAll();

    public function lastInsertId();

    public function prepare($query);

    public function bindParameter($types, array $attributes);

    public function execute();

    public function getResult();


} 