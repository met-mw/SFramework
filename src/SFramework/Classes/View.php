<?php
namespace SFramework\Classes;


use Exception;
use ReflectionProperty;
use SFramework\Interfaces\InterfaceView;

/**
 * Class View
 * @package SFramework\Classes
 *
 * Базовый класс представлений
 */
abstract class View implements InterfaceView {

    protected $optional = [];

    /**
     * Отрисовка представления
     * Предварительно проверяется заполнение полей представления
     *
     * @throws Exception
     */
    final public function render() {
        $objectFields = get_object_vars($this);
        foreach ($objectFields as $field => $value) {
            $reflection = new ReflectionProperty(get_class($this), $field);
            if (!in_array($field, $this->optional) && $reflection->isPublic() && is_null($value)) {
                throw new Exception("Поле \"{$field}\" в представлении не заполнено.");
            }
        }

        $this->currentRender();
    }

} 