<?php
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use SFramework\Application;

// System constants
define('SFW_ROOT', __DIR__ . DIRECTORY_SEPARATOR);
define('SFW_APP_ROOT', SFW_ROOT . 'App' . DIRECTORY_SEPARATOR);
define('SFW_APP_CONTROLLERS_ROOT', SFW_APP_ROOT . 'Controllers' . DIRECTORY_SEPARATOR);
define('SFW_APP_FRAMES_ROOT', SFW_APP_ROOT . 'Frames' . DIRECTORY_SEPARATOR);
define('SFW_APP_MODELS_ROOT', SFW_APP_ROOT . 'Models' . DIRECTORY_SEPARATOR);
define('SFW_APP_VIEWS_ROOT', SFW_APP_ROOT . 'Views' . DIRECTORY_SEPARATOR);
define('SFW_APP_VALIDATORS_ROOT', SFW_APP_ROOT . 'Validators' . DIRECTORY_SEPARATOR);

require_once('vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

// Configure and starting application
$request = new Request($_SERVER['REQUEST_METHOD'], new Uri($_SERVER['REQUEST_URI']), getallheaders());
$application = new Application($request, new Response());

$settings['datasource'] = require('App\Config\datasource.php');
$settings['general'] = require('App\Config\general.php');

echo $application->settings($settings)->run()->getBody();