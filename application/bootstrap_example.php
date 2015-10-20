<?php
/**
 * Любые пользователькие установки
 * Допускается произвольное изменение данного файла
 */

use kernel\classes\Frame;
use kernel\classes\Registry;
// Раскоментируй две следующие строки, если хочешь использовать БД
//use kernel\orm\classes\Orm_Registry;
//use kernel\orm\drivers\Mysql;


// Заполни конфиг db.php по примеру из db_example.php,
// раскомменируй две следующие строки, чтобы начать работу с базой данных MySQL/MariaDB
//$dbSettings = include('config' . DIRECTORY_SEPARATOR . 'db.php');
//Orm_Registry::add(new Mysql($dbSettings));

// Настраиваем роутер
$configFileName = 'application' .
    DIRECTORY_SEPARATOR . 'config' .
    DIRECTORY_SEPARATOR . 'route_example.php';
if (file_exists($configFileName)) {
    Registry::router()->setConfig(include($configFileName));
}

// Настраиваем фрейм
Registry::set('example', new Frame(), true);
Registry::frame('example')->setFrame('example');
Registry::frame('example')->setFavicon();
Registry::frame('example')->addMeta([
    'name' => 'viewport',
    'content' => 'width=device-width, initial-scale=1.0'
]);