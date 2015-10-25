<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 07.10.15
 */

namespace SFramework\Interfaces;


interface InterfaceParam {

    static public function get($name);

    static public function post($name);

    static public function request($name);

    static public function file($name);

} 