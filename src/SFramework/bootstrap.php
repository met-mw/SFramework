<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 03.10.15
 */


use SFramework\Classes\Registry;
use SFramework\Classes\Router;

Registry::set('router', new Router(), true);

$applicationBootstrap = 'application' . DIRECTORY_SEPARATOR . 'bootstrap.php';
if (file_exists($applicationBootstrap)) {
    include_once($applicationBootstrap);
}

$router = Registry::router();
$router->setRoute($_SERVER['REQUEST_URI']);
$router->route();