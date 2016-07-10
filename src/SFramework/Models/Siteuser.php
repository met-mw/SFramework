<?php
namespace SFramework\Models;


use SORM\Entity;

/**
 * Class Siteuser
 * @package SFramework\Models
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $password
 * @property string $date
 */
class Siteuser extends Entity
{

    protected $tableName = 'siteuser';

}