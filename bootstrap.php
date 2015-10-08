<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 03.10.15
 */
use kernel\classes\Registry;
use kernel\classes\Router;


include_once('kernel' . DIRECTORY_SEPARATOR . 'autoload.php');
include_once('application' . DIRECTORY_SEPARATOR . 'bootstrap.php');

Registry::set('router', new Router(), true);
$router = Registry::router();
$router->setRoute($_SERVER['REQUEST_URI']);
$router->route();