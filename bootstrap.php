<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 03.10.15
 */
use kernel\classes\Registry;
use kernel\classes\Router;


include_once('kernel' . DIRECTORY_SEPARATOR . 'autoload.php');
Registry::set('router', new Router(), true);

$applicationBootstrap = 'application' . DIRECTORY_SEPARATOR . 'bootstrap.php';
if (file_exists($applicationBootstrap)) {
    include_once($applicationBootstrap);
}
// Чтобы применить демонстрационые настройки раскомментируй следующую строку
//include_once('application' . DIRECTORY_SEPARATOR . 'bootstrap_example.php');

$router = Registry::router();
$router->setRoute($_SERVER['REQUEST_URI']);
$router->route();