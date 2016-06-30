<?php
namespace SFramework;


/**
 * Interface ViewInterface
 * @package SFramework
 */
interface ViewInterface
{

    /**
     * Get rendered view as string
     *
     * @return string
     */
    public function get();

    /**
     * Render view
     */
    public function render();

}