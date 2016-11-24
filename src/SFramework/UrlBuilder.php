<?php
namespace SFramework;


class UrlBuilder
{

    static public function build($path = '/', $params = [])
    {
        $url = $path;
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

}