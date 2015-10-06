<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 04.10.15
 */

namespace kernel\orm\interfaces;


interface Interface_Setting {

    /**
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public function setSetting($name, $value);

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getSetting($name);

    /**
     * @return array
     */
    public function getSettings();

} 