<?php
namespace SFramework\Classes;


use SFramework\Classes\Breadcrumbs\Node;

class Breadcrumbs {

    /** @var Node */
    protected $root;
    /** @var string */
    protected $url;
    /** @var string */
    protected $startingPath;

    public function __construct($url, $rootName, $rootPath = '', $startingPath = '') {
        $this->root = new Node($rootName, $rootPath == '' ? $startingPath : $startingPath . '/' . $rootPath);
        $this->url = $url;
        $this->startingPath = $startingPath;
    }

    public function getRoot() {
        return $this->root;
    }

    public function build() {
        $nodes = [];

        $urlParts = explode('/', $this->url);
        if (count($urlParts) > 1) {
            $urlParts = array_diff($urlParts, ['']);
            while (in_array(reset($urlParts), ['main', $this->startingPath])) {
                array_shift($urlParts);
            }
        }

        $nodes[] = $this->getRoot();
        if (!empty($urlParts)) {
            $nodes = array_merge($nodes, $this->getRoot()->build($urlParts));
        }
        return $nodes;
    }

} 