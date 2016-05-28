<?php
namespace SFramework\Interfaces;


interface InterfaceParam
{

    static public function get($name);

    static public function post($name);

    static public function request($name);

    static public function file($name);

} 