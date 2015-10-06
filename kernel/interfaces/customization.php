<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 07.10.15
 */

namespace kernel\interfaces;


interface Interface_Customization {

    public function asInteger();

    public function asString();

    public function asEmail();

    public function asBool();

    public function asArray();

} 