<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 04.10.15
 */

namespace kernel\orm\traits;

/**
 * Class Trait_Setting
 * @package kernel\orm\traits
 *
 * Примесь для классов.
 * Использование: В нужном классе прописать use Trait_Setting
 * Примешивание данного функционала к классу расширяет возможности класса,
 * в частности добавляет возможность хранить в классе неограниченное количество
 * данных (встроенный массив)
 */
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