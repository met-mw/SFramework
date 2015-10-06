<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 04.10.15
 */

namespace application\models;


use kernel\orm\Entity;

/**
 * Class Siteuser
 * @property int id
 * @property string email
 * @property boolean admin
 *
 * @package models
 */
class Model_Siteuser extends Entity {

    protected $tableName = 'siteuser';
    protected $primaryKeyName = 'id';

    protected $allowedFields = [
        'id',
        'email',
        'admin'
    ];

    protected $fieldTypes = [
        'id' => self::FIELD_TYPE_INTEGER,
        'email' => self::FIELD_TYPE_STRING,
        'admin' => self::FIELD_TYPE_INTEGER
    ];

} 