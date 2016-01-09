<?php
namespace SFramework\Classes;


use SFramework\Classes\Breadcrumbs\Node;

class Breadcrumbs {

    /** @var Node */
    protected $root;
    /** @var string */
    protected $route;
    /** @var string */
    protected $startingPath;
    /** @var string[] */
    protected $ignoreUrlParts = [];

    public function __construct($route, $rootName, $rootPath = '', $startingPath = '') {
        $this->root = new Node($rootName, $rootPath == '' ? $startingPath : $startingPath . '/' . $rootPath);
        $this->route = $route;
        $this->startingPath = $startingPath;
    }

    /**
     * @param string[] $ignores
     */
    public function setIgnores(array $ignores) {
        $this->ignoreUrlParts = $ignores;
    }

    public function getRoot() {
        return $this->root;
    }

    public function build() {
        $nodes = [];

        list($urlPath, $urlParams) = Registry::router()->splitRoute();
        $filteredParams = [];
        foreach (array_diff(explode('&', $urlParams), ['']) as $param) {
            if (!in_array(reset(explode('=', $param)), $this->ignoreUrlParts)) {
                $filteredParams[] = $param;
            }
        }
        $urlParts = explode('/', $urlPath);
        if (count($urlParts) > 1) {
            $urlParts = array_diff($urlParts, ['']);
            while (in_array(reset($urlParts), ['main', $this->startingPath])) {
                array_shift($urlParts);
            }
        }

        $nodes[] = $this->getRoot();
        if (!empty($urlParts)) {
            $nodes = array_merge($nodes, $this->getRoot()->build($urlParts, $filteredParams));
        }
        return $nodes;
    }

} 