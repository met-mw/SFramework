<?php
/**
 * Любые пользователькие установки
 * Допускается произвольное изменение данного файла
 */

use kernel\classes\Frame;
use kernel\classes\Registry;
use kernel\orm\Connection;
use kernel\orm\drivers\Mysql;


// Заполни конфиг db.php по примеру из db_example.php,
// замени "db_example.php" на "db.php" (или любое другое имя файла),
// раскомменируй три следующие строки, чтобы начать работу с базой данных MySQL/MariaDB
//$dbSettings = include('config' . DIRECTORY_SEPARATOR . 'db_example.php');
//Connection::instance()->connect(Mysql::DRIVER_CLASS, $dbSettings);
//Registry::set('dataSourceDriver', Connection::instance()->getDriver(), true);

Registry::set('frame', Frame::instance(), true);
Registry::frame()->setFrame('example');