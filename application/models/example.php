<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 04.10.15
 */

namespace application\models;


use kernel\orm\Entity;

/**
 * Class Model_Example
 * @property int $id
 * @property string $text
 *
 * @package models
 */
class Model_Example extends Entity {

    protected $tableName = 'example';
    protected $primaryKeyName = 'id';

    protected $allowedFields = [
        'id',
        'text'
    ];

    protected $fieldTypes = [
        'id' => self::FIELD_TYPE_INTEGER,
        'test' => self::FIELD_TYPE_STRING
    ];

} 