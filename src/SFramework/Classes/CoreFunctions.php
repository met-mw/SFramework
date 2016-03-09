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
        if (mb_strpos($uri, '?') !== false && preg_match('/(test=[^&]*){1}/', $uri)) {
            $uri = preg_replace('/(test=[^&]*){1}/', "{$name}={$value}", $uri);
        } else {
            $uri .= (mb_strpos($uri, '?') === false ? '?' : '&') . "{$name}={$value}";
        }

        return $uri;
    }

    static public function isAJAX() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

} 