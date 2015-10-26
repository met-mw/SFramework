<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 25.10.15
 */
if ($argc == 2) {

    $root = $argv[1];
    if (is_dir($root)) {
        echo 'Install...' . PHP_EOL . PHP_EOL;

        $appRoot = "{$root}App" . DIRECTORY_SEPARATOR;
        echo "Create directory: \"{$appRoot}\" - ";
        if (mkdir($appRoot)) {
            echo 'success.' . PHP_EOL;

            $routeRoot = "{$appRoot}Config" . DIRECTORY_SEPARATOR;
            echo "Create directory: \"{$routeRoot}\" - ";
            if (mkdir($routeRoot)) {
                echo 'success.' . PHP_EOL;

                // Создаём файл конфигурации роутера
            $configRoute = '<?php
return [
    \'controllersRoot\' => \'App\\\\Controllers\\\\\',

    \'defaultController\' => \'Main\',
    \'defaultControllerPrefix\' => \'Controller\',

    \'defaultAction\' => \'Index\',
    \'defaultActionPrefix\' => \'action\'
];';
            echo 'Create file: "' . $routeRoot . 'route.php" - ';
            echo (file_put_contents("{$routeRoot}route.php", $configRoute) !== false ? 'success.' : 'filed.') . PHP_EOL;
            } else {
                echo 'filed.' . PHP_EOL;
            }

            echo 'Create directory: "' . $root . 'app\Controllers" - ';
            echo (mkdir($appRoot . 'Controllers') ? 'success.' : 'filed.') . PHP_EOL;
            echo 'Create directory: "' . $root . 'app\Frames" - ';
            echo (mkdir($appRoot . 'Frames') ? 'success.' : 'filed.') . PHP_EOL;;
            echo 'Create directory: "' . $root . 'app\Migrations" - ';
            echo (mkdir($appRoot . 'Migrations') ? 'success.' : 'filed.') . PHP_EOL;;
            echo 'Create directory: "' . $root . 'app\Models" - ';
            echo (mkdir($appRoot . 'Models') ? 'success.' : 'filed.') . PHP_EOL;;
            echo 'Create directory: "' . $root . 'app\Views" - ';
            echo (mkdir($appRoot . 'Views') ? 'success.' : 'filed.') . PHP_EOL;;
        } else {
            echo 'filed.' . PHP_EOL;
        }

        $publicRoot = "{$root}public" . DIRECTORY_SEPARATOR;
        echo "Create directory: \"{$publicRoot}\" - ";
        if (mkdir($publicRoot)) {
            echo 'success.' . PHP_EOL;
        } else {
            echo 'filed.' . PHP_EOL;
        }

        $gitignore = '/.idea/
/vendor/';
        echo 'Create file: "' . $root . '.gitignore" - ';
        echo (file_put_contents("{$root}.gitignore", $gitignore) !== false ? 'success.' : 'filed.') . PHP_EOL;

        $htaccess = '<IfModule mod_rewrite.c>
RewriteEngine On
Options +FollowSymlinks
RewriteBase /

RewriteCond %{REQUEST_URI} !^\/public/(.*).(.*)
RewriteRule ^.*$ index.php [NC,L]
</IfModule>';
        echo 'Create file: "' . $root . '.htaccess" - ';
        echo (file_put_contents("{$root}.htaccess", $htaccess) !== false ? 'success.' : 'filed.') . PHP_EOL;

        // Создаём файл bootstrap
        $bootstrap = '<?php
use SFramework\\Classes\\Frame;
use SFramework\\Classes\\Registry;
use SFramework\\Classes\\Router;


require_once(\'vendor\' . DIRECTORY_SEPARATOR . \'autoload.php\');

Registry::set(\'router\', new Router(), true);

$configFileName = \'App\' .
    DIRECTORY_SEPARATOR . \'Config\' .
    DIRECTORY_SEPARATOR . \'route.php\';
if (file_exists($configFileName)) {
    Registry::router()->setConfig(include($configFileName));
}

Registry::set(\'example\', new Frame(\'App\\Frames\\\'), true);
Registry::frame(\'example\')->setFrame(\'example\');
Registry::frame(\'example\')->setFavicon();
Registry::frame(\'example\')->addMeta([
    \'name\' => \'viewport\',
    \'content\' => \'width=device-width, initial-scale=1.0\'
]);

$router = Registry::router();
$router->setRoute($_SERVER[\'REQUEST_URI\']);
$router->route();';
        echo 'Create file: "' . $root . 'bootstrap.php" - ';
        echo (file_put_contents("{$root}bootstrap.php", $bootstrap) !== false ? 'success.' : 'filed.') . PHP_EOL;


        $index = '<?php
define(\'SFW_ROOT\', __DIR__ . DIRECTORY_SEPARATOR);
define(\'SFW_APP_ROOT\', SFW_ROOT . \'App\' . DIRECTORY_SEPARATOR);
define(\'SFW_PUBLIC_ROOT\', SFW_ROOT . \'public\' . DIRECTORY_SEPARATOR);

define(\'SFW_PUBLIC_HREF\', \'/public/\');


require_once(\'bootstrap.php\');';
        echo 'Create file: "' . $root . 'index.php" - ';
        echo (file_put_contents("{$root}index.php", $index) !== false ? 'success.' : 'filed.') . PHP_EOL;
    }

    echo  PHP_EOL . 'Congratulations! Install successful.';
} else {
    echo "Specify the path for the installation. Example: php install.php C:\\path\\to\\site\\" . PHP_EOL;
}