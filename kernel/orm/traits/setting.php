<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 04.10.15
 */

namespace kernel\orm\traits;


trait Trait_Setting {

    private $settings = [];

    /**
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public function setSetting($name, $value) {
        $this->settings[$name] = $value;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getSetting($name) {
        return isset($this->settings[$name]) ? $this->settings[$name] : null;
    }

    /**
     * @return array
     */
    public function getSettings() {
        return $this->settings;
    }

    /**
     * @param array $settings
     */
    public function setSettings(array $settings = []) {
        $this->settings = $settings;
    }

    public function clearSettings() {
        $this->setSettings([]);
    }

}