<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 03.10.15
 */
use kernel\classes\Registry;
use kernel\classes\Router;
use kernel\orm\Connection;
use kernel\orm\drivers\Mysql;


include_once('kernel' . DIRECTORY_SEPARATOR . 'autoload.php');

//$dbSettings = include('application\config\db.php');
//Connection::instance()->connect(Mysql::DRIVER_CLASS, $dbSettings);

Registry::set('db', Connection::instance()->getDriver(), true);
Registry::set('router', new Router(), true);

$router = Registry::router();
$router->setRoute($_SERVER['REQUEST_URI']);
$router->route();