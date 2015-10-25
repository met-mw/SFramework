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

        // Создаём файл bootstrap
        $bootstrap = '<?php
use SFramework\\Classes\\Frame;
use SFramework\\Classes\\Registry;

$configFileName = \'app\' .
    DIRECTORY_SEPARATOR . \'config\' .
    DIRECTORY_SEPARATOR . \'route.php\';
if (file_exists($configFileName)) {
    Registry::router()->setConfig(include($configFileName));
}

Registry::set(\'example\', new Frame(), true);
Registry::frame(\'example\')->setFrame(\'example\');
Registry::frame(\'example\')->setFavicon();
Registry::frame(\'example\')->addMeta([
    \'name\' => \'viewport\',
    \'content\' => \'width=device-width, initial-scale=1.0\'
]);';
        echo 'Create file: "' . $root . 'bootstrap.php" - ';
        echo (file_put_contents("{$root}bootstrap.php", $bootstrap) !== false ? 'success.' : 'filed.') . PHP_EOL;

    }

    echo  PHP_EOL . 'Congratulations! Install successful.';
} else {
    echo "Specify the path for the installation. Example: php install.php C:\\path\\to\\site\\" . PHP_EOL;
}