<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 03.10.15
 */

use SFramework\Classes\Registry;
use SFramework\Classes\Router;

require_once('vendor' . DIRECTORY_SEPARATOR . 'autoload.php');
Registry::set('router', new Router(), true);

$applicationBootstrap = SFW_APP_ROOT . 'bootstrap.php';
if (file_exists($applicationBootstrap)) {
    require_once($applicationBootstrap);
}
// Чтобы применить демонстрационые настройки раскомментируй следующую строку
//include_once('application' . DIRECTORY_SEPARATOR . 'bootstrap_example.php');

$router = Registry::router();
$router->setRoute($_SERVER['REQUEST_URI']);
$router->route();