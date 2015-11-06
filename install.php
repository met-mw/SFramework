<?php
if ($argc >= 1) {

    $root = isset($argv[1]) ? $argv[1] : __DIR__ . DIRECTORY_SEPARATOR;
    if (is_dir($root)) {
        echo 'Install...' . PHP_EOL . PHP_EOL;

        $appRoot = "{$root}App" . DIRECTORY_SEPARATOR;
        echo "Create directory: \"{$appRoot}\" - ";
        if (mkdir($appRoot)) {
            echo 'success.' . PHP_EOL;

            $configRoot = "{$appRoot}Config" . DIRECTORY_SEPARATOR;
            echo "Create directory: \"{$configRoot}\" - ";
            if (mkdir($configRoot)) {
                echo 'success.' . PHP_EOL;

                // Создаём файл конфигурации роутера
            $configRoute = '<?php
return [
    \'controllersRoot\' => \'App\\\\Controllers\\\\\'
];';
            echo 'Create file: "' . $configRoot . 'route.php" - ';
            echo (file_put_contents("{$configRoot}route.php", $configRoute) !== false ? 'success.' : 'filed.') . PHP_EOL;
            } else {
                echo 'filed.' . PHP_EOL;
            }

            $controllerRoot = "{$appRoot}Controllers" . DIRECTORY_SEPARATOR;
            echo "Create directory: \"{$controllerRoot}\" - ";
            if (mkdir($controllerRoot)) {
                echo 'success.' . PHP_EOL;

                $controller = '<?php
namespace App\Controllers;


use SFramework\Classes\Controller;

class ControllerMain extends Controller {

    public function actionIndex() {
        // TODO: Здесь твой код
    }

}';
                echo "Create file: \"{$controllerRoot}ControllerMain.php\" - ";
                echo (file_put_contents("{$controllerRoot}ControllerMain.php", $controller) !== false ? 'success.' : 'filed.') . PHP_EOL;
            } else {
                echo 'filed.' . PHP_EOL;
            }

            $frameRoot = "{$appRoot}Frames" . DIRECTORY_SEPARATOR;
            echo "Create directory: \"{$configRoot}\" - ";
            if (mkdir($frameRoot)) {
                echo 'success.' . PHP_EOL;

                $frame = '<!DOCTYPE html>
<html>
    <head>
        <title>
            <!--label[title]-->
        </title>
        <!--label[meta]-->
        <!--label[favicon]-->
        <!--label[css]-->
        <!--label[js]-->
    </head>
    <body>
        <!--label[content]-->
    </body>
</html>';
                echo "Create file: \"{$frameRoot}main.html\" - ";
                echo (file_put_contents("{$frameRoot}main.html", $frame) !== false ? 'success.' : 'filed.') . PHP_EOL;
            } else {
                echo 'filed.' . PHP_EOL;
            }
            echo 'Create directory: "' . $root . 'app\Migrations" - ';
            echo (mkdir($appRoot . 'Migrations') ? 'success.' : 'filed.') . PHP_EOL;
            echo 'Create directory: "' . $root . 'app\Models" - ';
            echo (mkdir($appRoot . 'Models') ? 'success.' : 'filed.') . PHP_EOL;

            $viewRoot = "{$appRoot}Views" . DIRECTORY_SEPARATOR;
            echo "Create directory: \"{$viewRoot}\" - ";
            if (mkdir($viewRoot)) {
                echo 'success.' . PHP_EOL;

                $view = '<?php
namespace App\Views;


use SFramework\Classes\View;

class ViewMain extends View {

    public function currentRender() {
        // TODO: Рендер вьюшки
    }

}';
                echo "Create file: \"{$viewRoot}ViewMain.php\" - ";
                echo (file_put_contents("{$viewRoot}ViewMain.php", $view) !== false ? 'success.' : 'filed.') . PHP_EOL;
            } else {
                echo 'filed.' . PHP_EOL;
            }
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

Registry::set(\'main\', new Frame(SFW_APP_ROOT . \'Frames\' . DIRECTORY_SEPARATOR), true);
Registry::frame(\'main\')->setFrame(\'main\');
Registry::frame(\'main\')->setFavicon();
Registry::frame(\'main\')->addMeta([
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