<?php
namespace SFramework\Classes;


class CoreFunctions {

    static public function tagAttributesToString(array $tagAttributes, $separator = '') {
        $attributes = [];
        foreach ($tagAttributes as $name => $value) {
            $attributes[] = "{$name}=\"{$value}\"";
        }

        return implode($separator, $attributes);
    }

    static public function addGETParamToURI($uri, $name, $value) {
        $uri .= (mb_strpos($uri, '?') === false ? '?' : '&') . "{$name}={$value}";

        return $uri;
    }

} 