<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 03.10.15
 */

namespace kernel\orm\drivers;


use kernel\orm\Driver;
use mysqli;
use mysqli_result;
use mysqli_stmt;

/**
 * Class Mysql
 * @package kernel\orm\drivers
 *
 * Драйвер для работы с MySQL и MariaDB
 */
class Mysql extends Driver {

    /** @var mysqli */
    private $mysqli = null;
    /** @var mysqli_result|boolean */
    private $result = null;
    /** @var mysqli_stmt */
    private $stmt = null;

    public function __construct(array $settings = []) {
        $this->setSettings($settings);

        $host = $this->getSetting('host');
        $user = $this->getSetting('user');
        $password = $this->getSetting('password');
        $db = $this->getSetting('db');

        $this->mysqli = new mysqli($host, $user, $password, $db);

        if ($this->mysqli->connect_errno) {
            echo "Не удалось подключиться к MySQL: " . $this->mysqli->connect_error;
        }
    }

    public function query($query) {
        $this->result = $this->mysqli->query($query);
    }

    public function fetchAssoc() {
        return $this->result->fetch_assoc();
    }

    public function fetchRow() {
        return $this->result->fetch_row();
    }

    public function fetchFields() {
        return $this->result->fetch_fields();
    }

    public function fetchAll() {
        return $this->result->fetch_all();
    }

    public function lastInsertId() {
        return $this->mysqli->insert_id;
    }

    public function prepare($query) {
        $this->stmt = $this->mysqli->prepare($query);
    }

    public function bindParameter($types, array $attributes) {
        $preparedAttributes = [];
        $counter = 0;
        foreach ($attributes as $attribute) {
            $attributeName = "bindParam{$counter}";
            $$attributeName = $attribute;
            $preparedAttributes[] = &$$attributeName;
            $counter++;
        }
        array_unshift($preparedAttributes, $types);
        call_user_func_array([$this->stmt, 'bind_param'], $preparedAttributes);
    }

    public function execute() {
        $this->stmt->execute();
    }

    public function getResult() {
        $this->result;
    }

}