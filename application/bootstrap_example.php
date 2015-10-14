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
// раскомменируй три следующие строки, чтобы начать работу с базой данных MySQL/MariaDB
//$dbSettings = include('config' . DIRECTORY_SEPARATOR . 'db.php');
//Connection::instance()->connect(Mysql::DRIVER_CLASS, $dbSettings);
//Registry::set('dataSourceDriver', Connection::instance()->getDriver(), true);

// Настраиваем роутер
$configFileName = 'application' .
    DIRECTORY_SEPARATOR . 'config' .
    DIRECTORY_SEPARATOR . 'route_example.php';
if (file_exists($configFileName)) {
    Registry::router()->setConfig(include($configFileName));
}

// Настраиваем фрейм
Registry::set('frame', Frame::instance(), true);
Registry::frame()->setFrame('example');
Registry::frame()->addFavicon();
Registry::frame()->addMeta([
    'name' => 'viewport',
    'content' => 'width=device-width, initial-scale=1.0'
]);