<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 04.10.15
 */

/**
 * Автоматическое подключение запрашиваемых классов.
 *
 * @param string $class Полное имя класса
 */
function autoload($class) {
    $classNameParts = explode(DIRECTORY_SEPARATOR, $class);
    $count = count($classNameParts);
    $path = '';
    for ($i = 0; $i < $count; $i++) {
        $classNamePart = $classNameParts[$i];

        if ($i > 0) {
            $path .= DIRECTORY_SEPARATOR;
        }

        $path .= mb_strtolower(end(explode('_', $classNamePart)));

        if ($i == $count - 1) {
            $path .= '.php';
        }
    }

    if (file_exists($path)) {
        include_once($path);
    }
}

spl_autoload_register('autoload');