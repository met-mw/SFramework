<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 03.10.15
 */


use SFramework\Classes\Registry;
use SFramework\Classes\Router;

Registry::set('router', new Router(), true);

$router = Registry::router();
$router->setRoute($_SERVER['REQUEST_URI']);
$router->route();