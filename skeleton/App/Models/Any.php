<?php
namespace App\Models;


use SORM\Entity;

/**
 * Class Any
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class Any extends Entity
{

    public $tableName = 'any';

}