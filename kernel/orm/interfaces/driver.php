<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 03.10.15
 */

namespace kernel\orm\interfaces;


interface Interface_Driver {

    public function query($query);

    public function fetchAssoc();

    public function fetchRow();

    public function fetchFields();

    public function lastInsertId();

    public function prepare($query);

    public function bindParameter($types, array $attributes);

    public function execute();

} 