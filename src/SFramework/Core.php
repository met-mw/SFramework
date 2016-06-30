<?php
namespace SFramework;


class Core
{

    /**
     * Check request ajax
     *
     * @return bool
     */
    static public function isAJAX()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

}