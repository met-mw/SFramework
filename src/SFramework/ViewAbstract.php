<?php
namespace SFramework;


use Exception;
use ReflectionProperty;

/**
 * Class ViewAbstract
 * @package SFramework
 */
abstract class ViewAbstract implements ViewInterface
{

    protected $optional = [];

    /**
     * @return void
     */
    abstract protected function currentRender();

    /**
     * Render view
     *
     * @throws Exception
     */
    final public function render()
    {
        $objectFields = get_object_vars($this);
        foreach ($objectFields as $field => $value) {
            $reflection = new ReflectionProperty(get_class($this), $field);
            if (!in_array($field, $this->optional) && $reflection->isPublic() && is_null($value)) {
                throw new Exception("Field \"{$field}\" must be filled.");
            }
        }

        $this->currentRender();
    }

    /**
     * Get rendered view as string
     *
     * @return string
     */
    public function get()
    {
        ob_start();
        $this->render();
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}