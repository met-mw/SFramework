<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 07.10.15
 */

namespace SFramework\Classes;


use Exception;
use ReflectionProperty;
use SFramework\Interfaces\InterfaceView;

abstract class View implements InterfaceView {

    final public function render() {
        $objectFields = get_object_vars($this);
        foreach ($objectFields as $field => $value) {
            $reflection = new ReflectionProperty(get_class($this), $field);
            if ($reflection->isPublic() && is_null($value)) {
                throw new Exception("Поле \"{$field}\" в представлении не заполнено.");
            }
        }

        $this->currentRender();
    }

    abstract public function currentRender();

} 